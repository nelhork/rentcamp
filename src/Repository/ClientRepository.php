<?php

namespace App\Repository;

use App\Entity\Client;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Client>
 */
class ClientRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Client::class);
    }

    public function getAllClients(): array
    {
        return $this->createQueryBuilder('c')
            ->select('c.id', 'c.name')
            ->orderBy('c.id', 'ASC')
            ->getQuery()
            ->getArrayResult();
    }

    public function findByPhone(string $phone): array
    {
        return $this->createQueryBuilder('c')
            ->select('c.id', 'c.name', 'c.phone1', 'c.phone2', 'c.phone3')
            ->where('c.phone1 = :phone')
            ->orWhere('c.phone2 = :phone')
            ->orWhere('c.phone3 = :phone')
            ->setParameter('phone', $phone)
            ->getQuery()
            ->getArrayResult();
    }

    public function findByAnyPhone(string $phone): ?Client
    {
        return $this->createQueryBuilder('c')
            ->where('c.phone1 = :phone')
            ->orWhere('c.phone2 = :phone')
            ->orWhere('c.phone3 = :phone')
            ->setParameter('phone', $phone)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
