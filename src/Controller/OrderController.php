<?php

namespace App\Controller;

use App\Repository\OrderRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Exception\ORMException;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Order;
use App\Entity\ModelsToOrders;
use App\Entity\Client;
use App\Repository\ClientRepository;
use App\Repository\ModelRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Stock;
use App\Entity\Employee;
use App\Entity\Item;

final class OrderController extends AbstractController
{
//    Список id заказов
    #[Route('/order', name: 'app_order', methods: ['GET'])]
    public function index(Request $request, OrderRepository $orderRepository): JsonResponse
    {
        return $this->json($orderRepository->getListOrders($request->query->all()));
    }

//    Список заказов по фильтрам (с параметрами)
    #[Route('/order/details/filter', name: 'app_order_details_filter', methods: ['GET'])]
    public function getDetails(Request $request, OrderRepository $orderRepository): JsonResponse
    {
        return $this->json($orderRepository->getListOrdersWithDetails($request->query->all()));
    }

//    Детали заказа с моделями (с параметром)
    #[Route('order/details', name: 'app_order_details', methods: ['GET'])]
    public function getOrderDetails(Request $request, OrderRepository $orderRepository): JsonResponse
    {
        return $this->json($orderRepository->getOrderDetails((int)$request->query->get('id')));
    }

    private function renderNewOrderPage(
        ClientRepository $clientRepository,
        ModelRepository $modelRepository,
        EntityManagerInterface $entityManager
    ): Response
    {
        return $this->render('order/new.html.twig', [
            'clients' => $clientRepository->getAllClients(),
            'models' => $modelRepository->getAllModels(),
            'stocks' => $entityManager->getRepository(Stock::class)->getAllStocks(),
            'employees' => $entityManager->getRepository(Employee::class)->findAll(),
            'data' => [
                'begin' => (new \DateTime())->format('Y-m-d\TH:i'),
                'end_time' => (new \DateTime())->modify('+1 day')->format('Y-m-d\TH:i')
            ]
        ]);
    }

    private function validateOrderDates(array $data)
    {
        $begin = new \DateTime($data['begin']);
        $end = new \DateTime($data['end_time']);

        if ($begin > $end)
        {
            throw new \Exception('Дата начала не может быть позже даты окончания');
        }

        if ($begin < new \DateTime())
        {
            throw new \Exception('Дата начала не может быть в прошлом');
        }
    }

    /**
     * @throws ORMException
     */
    private function createNewOrder(
        ClientRepository $clientRepository,
        array $data,
        EntityManagerInterface $entityManager
    ): Order|null
    {
        $client = $clientRepository->find($data['client_id']);

        if (!$client)
        {
            return null;
        }

        $order = new Order();
        $order->setClientId($client);
        $order->setComment($data['comment'] ?? '');
        $order->setBegin(new \DateTime($data['begin']));
        $order->setEndTime(new \DateTime($data['end_time']));
        $order->setDeliveryAddressTo($data['delivery_address_to'] ?? '');
        $order->setDeliveryAddressFrom($data['delivery_address_from'] ?? '');
        $order->setDeliveryPrice($data['delivery_price'] ?? 0);
        $order->setTotalAmount($data['total_amount'] ?? 0);
        $order->setTotalDeposit($data['total_deposit'] ?? 0);
        $order->setCreated(new \DateTime());

        $this->setOrderRelations($data, $order, $entityManager);

        $entityManager->persist($order);

        return $order;
    }

    #[Route('/order/create', name: 'app_order_create', methods: ['GET', 'POST'])]
    public function createOrder(
        Request $request,
        EntityManagerInterface $entityManager,
        ClientRepository $clientRepository,
        ModelRepository $modelRepository
    )
    {
        if ($request->isMethod('GET')) {
            return $this->renderNewOrderPage($clientRepository, $modelRepository, $entityManager);
        }

        $data = $request->request->all();

        try {
            $this->validateOrderDates($data);

            // Сохранеие заказа
            $order = $this->createNewOrder($clientRepository, $data, $entityManager);
            if (!$order)
            {
                return $this->renderNewOrderPage($clientRepository, $modelRepository, $entityManager);
            }

            // Добавление модели в заказ
            $this->addModelsToOrder($data, $entityManager, $order);
            $entityManager->flush();
            $this->addFlash('success', 'Заказ успешно создан');
            return $this->redirectToRoute('app_order_details', ['id' => $order->getId()]);
        }
        catch (Exception $exception)
        {
            return $this->renderNewOrderPage($clientRepository, $modelRepository, $entityManager);
        }
    }

    /**
     * @param array $data
     * @param $order
     * @param EntityManagerInterface $entityManager
     * @return void
     * @throws ORMException
     */
    private function setOrderRelations(array $data, $order, EntityManagerInterface $entityManager): void
    {
        if (!empty($data['giver_id'])) {
            $order->setGiverId($entityManager->getReference('App\Entity\Employee', $data['giver_id']));
        }
        if (!empty($data['taker_id'])) {
            $order->setTakerId($entityManager->getReference('App\Entity\Employee', $data['taker_id']));
        }
        if (!empty($data['give_stock_id'])) {
            $order->setGiveStockId($entityManager->getReference('App\Entity\Stock', $data['give_stock_id']));
        }
        if (!empty($data['take_stock_id'])) {
            $order->setTakeStockId($entityManager->getReference('App\Entity\Stock', $data['take_stock_id']));
        }

        $order->setStatusId($entityManager->getReference('App\Entity\Status', 1));
    }

    /**
     * @param array $data
     * @param EntityManagerInterface $entityManager
     * @param $order
     * @throws ORMException
     * @throws Exception
     */
    private function addModelsToOrder(array $data, EntityManagerInterface $entityManager, $order): void
    {
        foreach ($data['models'] as $modelId)
        {
            $model = $entityManager->getReference('App\Entity\Model', $modelId);

            $modelsToOrders = new ModelsToOrders();
            $modelsToOrders->setModel($model);
            $modelsToOrders->setOrder($order);
            $modelsToOrders->setModelId($modelId);
            $modelsToOrders->setOrderId($order->getId());

            $entityManager->persist($modelsToOrders);

            $availableItems = $entityManager->getRepository(Item::class)->findAvailableItems($modelId, new \DateTime($data['begin']), new \DateTime($data['end_time']));

            if (empty($availableItems))
            {
                throw new \Exception("No available items found for model ID: $modelId");
            }

            $item = $availableItems[0];
            $order->addItem($item);
            $entityManager->persist($item);
        }
    }
}
