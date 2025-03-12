<?php

namespace App\Repository;

use App\Entity\Item;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Item>
 */
class ItemRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Item::class);
    }

    public function findAvailableItems(int $modelId, \DateTime $begin, \DateTime $end): array
    {
        return $this->createQueryBuilder('i')
            ->join('i.model', 'm')
            ->where('m.id = :modelId')
            ->andWhere('i.status = :status')
            ->setParameter('modelId', $modelId)
            ->setParameter('status', 'доступен')
            ->getQuery()
            ->getResult();
    }
}
