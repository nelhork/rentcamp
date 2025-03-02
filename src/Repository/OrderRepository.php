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

    public function getListOrders(array $params)
    {
        $db = $this->createQueryBuilder('o')
            ->select('DISTINCT o.id')
            ->innerJoin('o.client', 'c')
            ->innerJoin('o.status', 's');

        $conditions = [
            'phone' => function ($db, $value)
            {
                $db->where('c.phone1 = :phone')
                    ->orWhere('c.phone2 = :phone')
                    ->orWhere('c.phone3 = :phone')
                    ->setParameter('phone', $value);
            },
            'comment' => function ($db, $value)
            {
                $db->where('o.comment = :comment')
                    ->setParameter('comment', $value);
            },
            'status' => function ($db, $value)
            {
                $db->where('s.name = :status')
                    ->setParameter('status', $value);
            },
            'client_id' => function ($db, $value)
            {
                $db->where('o.client = :client_id')
                    ->setParameter('client_id', $value);
            },
            'order_id' => function ($db, $value)
            {
                $db->where('o.id = :order_id')
                    ->setParameter('order_id', $value);
            },
            'begin' => function ($db, $value)
            {
                $db->where('DATE(o.begin) = DATE(:begin)')
                    ->setParameter('begin', \DateTime::createFromFormat('d.m.Y H:i:s', $value));
            },
            'end_time' => function ($db, $value)
            {
                $db->where('DATE(o.end_time) = DATE(:end_time)')
                    ->setParameter('end_time', \DateTime::createFromFormat('d.m.Y H:i:s', $value));
            },
            'total_amount' => function ($db, $value)
            {
                $db->where('o.total_amount = :total_amount')
                    ->setParameter('total_amount', $value);
            },
            'total_deposit' => function ($db, $value)
            {
                $db->where('o.total_deposit = :total_deposit')
                    ->setParameter('total_deposit', $value);
            },
            'giver_id' => function ($db, $value)
            {
                $db->where('o.giver = :giver_id')
                    ->setParameter('giver_id', $value);
            },
            'taker_id' => function ($db, $value)
            {
                $db->where('o.taker = :taker_id')
                    ->setParameter('taker_id', $value);
            },
            'give_stock_id' => function ($db, $value)
            {
                $db->where('o.give_stock = :give_stock_id')
                    ->setParameter('give_stock_id', $value);
            },
            'take_stock_id' => function ($db, $value)
            {
                $db->where('o.take_stock = :take_stock_id')
                    ->setParameter('take_stock_id', $value);
            }
        ];

        // Применить фильтры из переданных параметров
        foreach ($params as $key => $value)
        {
            if (array_key_exists($key, $conditions) && !empty($value))
            {
                $conditions[$key]($db, $value);
            }
        }

        return $db->getQuery()->getResult();
    }

    public function getListOrdersWithDetails(array $params)
    {
        $db = $this->createQueryBuilder('o')
            ->select('
                o.id,
                s.name as status,
                o.comment,
                c.id as client_id,
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
                ts.id as take_stock_id
            ')
            ->innerJoin('o.status', 's')
            ->innerJoin('o.client', 'c')
            ->leftJoin('o.giver', 'g')
            ->leftJoin('o.taker', 't')
            ->leftJoin('o.give_stock', 'gs')
            ->leftJoin('o.take_stock', 'ts');

        $conditions = [
            'phone' => function ($db, $value)
            {
                $db->andWhere('c.phone1 = :phone OR c.phone2 = :phone OR c.phone3 = :phone')
                    ->setParameter('phone', $value);
            },
            'comment' => function ($db, $value)
            {
                $db->andWhere('o.comment = :comment')
                    ->setParameter('comment', $value);
            },
            'status' => function ($db, $value)
            {
                $db->andWhere('s.name = :status')
                    ->setParameter('status', $value);
            },
            'client_id' => function ($db, $value)
            {
                $db->andWhere('o.client = :client_id')
                    ->setParameter('client_id', $value);
            },
            'order_id' => function ($db, $value)
            {
                $db->andWhere('o.id = :order_id')
                    ->setParameter('order_id', $value);
            },
            'begin' => function ($db, $value)
            {
                $date = \DateTime::createFromFormat('d.m.Y H:i:s', $value);
                if ($date)
                {
                    $db->andWhere('o.begin BETWEEN :begin_start AND :begin_end')
                        ->setParameter('begin_start', $date->format('Y-m-d 00:00:00'))
                        ->setParameter('begin_end', $date->format('Y-m-d 23:59:59'));
                }
            },
            'end_time' => function ($db, $value)
            {
                $date = \DateTime::createFromFormat('d.m.Y H:i:s', $value);
                if ($date)
                {
                    $db->andWhere('o.end_time BETWEEN :end_start AND :end_end')
                        ->setParameter('end_start', $date->format('Y-m-d 00:00:00'))
                        ->setParameter('end_end', $date->format('Y-m-d 23:59:59'));
                }
            },
            'total_amount' => function ($db, $value)
            {
                $db->andWhere('o.total_amount = :total_amount')
                    ->setParameter('total_amount', $value);
            },
            'total_deposit' => function ($db, $value)
            {
                $db->andWhere('o.total_deposit = :total_deposit')
                    ->setParameter('total_deposit', $value);
            },
            'giver_id' => function ($db, $value)
            {
                $db->andWhere('o.giver = :giver_id')
                    ->setParameter('giver_id', $value);
            },
            'taker_id' => function ($db, $value)
            {
                $db->andWhere('o.taker = :taker_id')
                    ->setParameter('taker_id', $value);
            },
            'give_stock_id' => function ($db, $value)
            {
                $db->andWhere('o.give_stock = :give_stock_id')
                    ->setParameter('give_stock_id', $value);
            },
            'take_stock_id' => function ($db, $value)
            {
                $db->andWhere('o.take_stock = :take_stock_id')
                    ->setParameter('take_stock_id', $value);
            }
        ];

        // Применить фильтры из переданных параметров
        foreach ($params as $key => $value)
        {
            if (isset($conditions[$key]) && !empty($value))
            {
                $conditions[$key]($db, $value);
            }
        }

        return $db->getQuery()->getResult();
    }
}
