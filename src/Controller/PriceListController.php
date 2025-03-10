<?php

namespace App\Controller;

use App\Repository\PricelistRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

final class PriceListController extends AbstractController
{
    #[Route('/price', name: 'app_price_list')]
    public function index(Request $request, PricelistRepository $priceRepository, SerializerInterface $serializer): JsonResponse
    {
        $modelId = $request->query->get('modelId');

        $begin = new \DateTime($request->query->get('begin'));
        $end = new \DateTime($request->query->get('end'));
        $diff = $begin->diff($end);

        $prices = $priceRepository->findPrice($modelId, $diff->days);
        $normalizePrices = [];

        foreach ($prices as $price)
        {
            $normalizePrices[] = [
              'model_id' => $price->getModelId(), 'period_min' => $price->getPeriodMin(), 'period_max' => $price->getPeriodMax()
            ];
        }

        return $this->json($normalizePrices);
    }
}
