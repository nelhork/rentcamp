<?php

namespace App\Repository;

use App\Entity\Stock;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Stock>
 */
class StockRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Stock::class);
    }

    public function getAllStocks(): array
    {
        return $this->createQueryBuilder('s')
            ->select('s.id', 's.name', 's.address')
            ->orderBy('s.id', 'ASC')
            ->getQuery()
            ->getArrayResult();
    }
}
