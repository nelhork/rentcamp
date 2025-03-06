<?php

namespace App\Repository;

use App\Entity\Order;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Order>
 */
class OrderRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Order::class);
    }

    public function getListOrders(array $params): array
    {
        $queryBuilder = $this->createQueryBuilder('o')
            ->select('o.id')
            ->innerJoin('o.client', 'c')
            ->innerJoin('o.status', 's')
            ->orderBy('o.id', 'ASC');

        $this->applyFilters($queryBuilder, $params);

        return $queryBuilder->getQuery()->getArrayResult();
    }

    public function getListOrdersWithDetails(array $params): array
    {
        $queryBuilder = $this->createQueryBuilder('o')
            ->select('
                o.id,
                s.name as status,
                o.comment,
                c.id as client_id,
                c.name as client_name,
                o.created,
                o.begin,
                o.end_time as end,
                o.delivery_address_to,
                o.delivery_address_from,
                o.total_amount,
                o.total_deposit,
                g.id as giver_id,
                t.id as taker_id,
                gs.id as give_stock_id,
                ts.id as take_stock_id,
                m.id as model_id,
                m.name as model_name
            ')
            ->innerJoin('o.status', 's')
            ->innerJoin('o.client', 'c')
            ->innerJoin('o.modelsToOrders', 'mto')
            ->innerJoin('mto.modelRef', 'm')
            ->leftJoin('o.giver', 'g')
            ->leftJoin('o.taker', 't')
            ->leftJoin('o.give_stock', 'gs')
            ->leftJoin('o.take_stock', 'ts');

        $this->applyFilters($queryBuilder, $params);

        return $queryBuilder->getQuery()->getArrayResult();
    }

    private function applyFilters($queryBuilder, array $params): void
    {
        if (!empty($params['phone']))
        {
            $queryBuilder->andWhere('c.phone1 = :phone OR c.phone2 = :phone OR c.phone3 = :phone')
                ->setParameter('phone', $params['phone']);
        }

        if (!empty($params['comment']))
        {
            $queryBuilder->andWhere('o.comment = :comment')
                ->setParameter('comment', $params['comment']);
        }

        if (!empty($params['status']))
        {
            $queryBuilder->andWhere('s.name = :status')
                ->setParameter('status', $params['status']);
        }

        if (!empty($params['client_id']))
        {
            $queryBuilder->andWhere('o.client = :client_id')
                ->setParameter('client_id', $params['client_id']);
        }

        if (!empty($params['order_id']))
        {
            $queryBuilder->andWhere('o.id = :order_id')
                ->setParameter('order_id', $params['order_id']);
        }

        if (!empty($params['begin']))
        {
            $date = \DateTime::createFromFormat('d.m.Y H:i:s', $params['begin']);
            if ($date)
            {
                $queryBuilder->andWhere('o.begin BETWEEN :begin_start AND :begin_end')
                    ->setParameter('begin_start', $date->format('Y-m-d 00:00:00'))
                    ->setParameter('begin_end', $date->format('Y-m-d 23:59:59'));
            }
        }

        if (!empty($params['end_time']))
        {
            $date = \DateTime::createFromFormat('d.m.Y H:i:s', $params['end_time']);
            if ($date)
            {
                $queryBuilder->andWhere('o.end_time BETWEEN :end_start AND :end_end')
                    ->setParameter('end_start', $date->format('Y-m-d 00:00:00'))
                    ->setParameter('end_end', $date->format('Y-m-d 23:59:59'));
            }
        }

        if (!empty($params['total_amount']))
        {
            $queryBuilder->andWhere('o.total_amount = :total_amount')
                ->setParameter('total_amount', $params['total_amount']);
        }

        if (!empty($params['total_deposit']))
        {
            $queryBuilder->andWhere('o.total_deposit = :total_deposit')
                ->setParameter('total_deposit', $params['total_deposit']);
        }

        if (!empty($params['giver_id']))
        {
            $queryBuilder->andWhere('o.giver = :giver_id')
                ->setParameter('giver_id', $params['giver_id']);
        }

        if (!empty($params['taker_id']))
        {
            $queryBuilder->andWhere('o.taker = :taker_id')
                ->setParameter('taker_id', $params['taker_id']);
        }

        if (!empty($params['give_stock_id']))
        {
            $queryBuilder->andWhere('o.give_stock = :give_stock_id')
                ->setParameter('give_stock_id', $params['give_stock_id']);
        }

        if (!empty($params['take_stock_id']))
        {
            $queryBuilder->andWhere('o.take_stock = :take_stock_id')
                ->setParameter('take_stock_id', $params['take_stock_id']);
        }
    }
}
