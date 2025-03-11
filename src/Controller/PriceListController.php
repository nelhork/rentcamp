<?php

namespace App\Controller;

use App\Repository\PricelistRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

final class PriceListController extends AbstractController
{
    #[Route('/price', name: 'app_price_list')]
    public function index(Request $request, PricelistRepository $priceRepository): JsonResponse
    {
        $modelId = $request->query->get('model_id');

        $begin = new \DateTime($request->query->get('begin'));
        $end = new \DateTime($request->query->get('end'));
        $diff = $begin->diff($end);

        $prices = $priceRepository->findPrice($modelId, $diff->days);
        $normalizePrices = [];

        foreach ($prices as $price)
        {
            $normalizePrices[] = [
                'model_id' => $price->getModel()->getId(),
                'price_for_period' => $price->getPriceForPeriod(),
                'deposit_for_period' => $price->getDepositForPeriod(),
                'period_min' => $price->getPeriodMin(),
                'period_max' => $price->getPeriodMax()
            ];
        }

        return $this->json($normalizePrices);
    }
}
