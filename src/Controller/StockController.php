<?php

namespace App\Controller;

use App\Repository\StockRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

final class StockController extends AbstractController
{
    #[Route('/stock', name: 'app_stock', methods: ['GET'])]
    public function index(StockRepository $stockRepository): JsonResponse
    {
        $stocks = $stockRepository->getAllStocks();

        return $this->json($stocks);
    }
}
