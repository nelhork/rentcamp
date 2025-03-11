<?php

namespace App\Controller;

use App\Repository\ClientRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Client;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;

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

    #[Route('/client/new', name: 'app_client_new', methods: ['GET'])]
    public function new(): Response
    {
        return $this->render('client/new.html.twig');
    }

    #[Route('/client/create', name: 'app_client_create', methods: ['POST'])]
    public function create(Request $request, ClientRepository $clientRepository, EntityManagerInterface $entityManager): Response
    {
        $data = $request->request->all();

        if (empty($data['name']) || empty($data['phone1']))
        {
            return $this->json(['message' => 'Имя и основной телефон обязательны'], Response::HTTP_BAD_REQUEST);
        }

        foreach ([$data['phone1'], $data['phone2'] ?? null, $data['phone3'] ?? null] as $phone)
        {
            if ($phone && $clientRepository->findByAnyPhone($phone))
            {
                return $this->json(['message' => 'Клиент уже существует с таким номером'], Response::HTTP_CONFLICT);
            }
        }

        $client = new Client();
        $client->setName($data['name']);
        $client->setPhone1($data['phone1']);
        $client->setPhone2($data['phone2'] ?? null);
        $client->setPhone3($data['phone3'] ?? null);
        $client->setComment($data['comment'] ?? '');

        $entityManager->persist($client);
        $entityManager->flush();

        return $this->redirectToRoute('app_client_by_phone', ['phone' => $client->getPhone1()]);
    }
}
