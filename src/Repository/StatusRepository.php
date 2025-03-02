<?php

namespace App\Repository;

use App\Entity\Status;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Status>
 */
class StatusRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Status::class);
    }

    public function getAllStatuses(): array
    {
        return $this->createQueryBuilder('s')
            ->select('s.id', 's.name')
            ->orderBy('s.id', 'ASC')
            ->getQuery()
            ->getArrayResult();
    }
}
