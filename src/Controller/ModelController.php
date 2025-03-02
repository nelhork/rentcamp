<?php

namespace App\Controller;

use App\Repository\ModelRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

final class ModelController extends AbstractController
{
    #[Route('/model', name: 'app_model', methods: ['GET'])]
    public function index(ModelRepository $modelRepository): JsonResponse
    {
        $models = $modelRepository->getAllModels();

        return $this->json($models);
    }
}
