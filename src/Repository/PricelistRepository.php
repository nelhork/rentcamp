<?php

namespace App\Repository;

use App\Entity\Pricelist;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Pricelist>
 */
class PricelistRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Pricelist::class);
    }

    public function findPrice($modelId, float $period)
    {
        $queryBuilder = $this->createQueryBuilder('p')
            ->where('p.model_id = :modelId')
            ->setParameter('modelId', $modelId)
            ->andWhere(':period BETWEEN p.period_min AND p.period_max')
            ->setParameter('period', $period)
            ->getQuery();

        return $queryBuilder->getResult();
    }
}
