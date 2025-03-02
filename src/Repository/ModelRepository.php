<?php

namespace App\Repository;

use App\Entity\Model;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Model>
 */
class ModelRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Model::class);
    }

    public function getAllModels(): array
    {
        return $this->createQueryBuilder('m')
            ->select('m.id', 'm.name')
            ->orderBy('m.id', 'ASC')
            ->getQuery()
            ->getArrayResult();
    }
}
