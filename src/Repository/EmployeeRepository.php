<?php

namespace App\Repository;

use App\Entity\Employee;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Employee>
 */
class EmployeeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Employee::class);
    }

    public function getAllEmployees(): array
    {
        return $this->createQueryBuilder('e')
            ->select('e.id', 'e.name')
            ->orderBy('e.id', 'ASC')
            ->getQuery()
            ->getArrayResult();
    }
}
