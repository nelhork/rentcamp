<?php

namespace App\Controller;

use App\Repository\OrderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

final class OrderController extends AbstractController
{
    #[Route('/order', name: 'app_order', methods: ['GET'])]
    public function index(Request $request, OrderRepository $orderRepository): JsonResponse
    {
        $params = $request->query->all();
        $orders = $orderRepository->getListOrders($params);

        return $this->json($orders);
    }

    #[Route('/order/details/filter', name: 'app_order_details_filter', methods: ['GET'])]
    public function getDetails(Request $request, OrderRepository $orderRepository): JsonResponse
    {
        $params = $request->query->all();
        $orders = $orderRepository->getListOrdersWithDetails($params);

        return $this->json($orders);
    }

    #[Route('order/details', name: 'app_order_details', methods: ['GET'])]
    public function getOrderDetails(Request $request, OrderRepository $orderRepository): JsonResponse
    {
        $orderId = $request->query->get('id');
        $orderDetails = $orderRepository->getOrderDetails((int)$orderId);

        return $this->json($orderDetails);
    }
}
