<?php

namespace App\Controller;

use App\Repository\StatusRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

final class StatusController extends AbstractController
{
    #[Route('/status', name: 'app_status', methods: ['GET'])]
    public function index(StatusRepository $statusRepository): JsonResponse
    {
        $statuses = $statusRepository->getAllStatuses();

        return $this->json($statuses);
    }
}
