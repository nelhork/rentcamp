<?php

namespace App\Controller;

use App\Entity\Order;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

final class OrderController extends AbstractController
{
    #[Route('/order', name: 'app_order')]
    public function index(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $params = $request->query->all();

        $orders = $entityManager->getRepository(Order::class)->getListOrders($params);

        $ids = [];
        foreach ($orders as $order)
        {
            $ids[] = $order['id'];
        }

        return $this->json($ids);
    }

    #[Route('/order/details', name: 'app_order_details')]
    public function getDetails(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $params = $request->query->all();

        $orders = $entityManager->getRepository(Order::class)->getListOrdersWithDetails($params);

        return $this->json($orders);
    }
}
