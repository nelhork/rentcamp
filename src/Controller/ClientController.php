<?php

namespace App\Controller;

use App\Repository\ClientRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

final class ClientController extends AbstractController
{
    #[Route('/client/by-phone/{phone}', name: 'app_client_by_phone', methods: ['GET'])]
    public function index(string $phone, ClientRepository $clientRepository): JsonResponse
    {
        $clients = $clientRepository->findByPhone($phone);

        if (empty($clients))
        {
            return $this->json(['message' => 'Клиент не найден'], 404);
        }

        return $this->json($clients);
    }
}
