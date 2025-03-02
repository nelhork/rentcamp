<?php

namespace App\Controller;

use App\Repository\EmployeeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

final class EmployeeController extends AbstractController
{
    #[Route('/employee', name: 'app_employee', methods: ['GET'])]
    public function index(EmployeeRepository $employeeRepository): JsonResponse
    {
        $employees = $employeeRepository->getAllEmployees();

        return $this->json($employees);
    }
}
