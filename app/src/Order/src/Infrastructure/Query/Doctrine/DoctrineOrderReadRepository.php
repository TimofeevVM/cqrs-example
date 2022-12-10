<?php

declare(strict_types=1);

namespace Order\Infrastructure\Query\Doctrine;

use Doctrine\DBAL\Query\QueryBuilder;
use Doctrine\ORM\EntityManagerInterface;
use Order\Application\Query\OrderReadModel;
use Order\Application\Query\OrderReadRepository;

class DoctrineOrderReadRepository implements OrderReadRepository
{
    public function __construct(
        private readonly EntityManagerInterface $em
    ) {
    }

    public function getMostRecent(string $customerId, int $limit, int $offset): array
    {
        $qb = new QueryBuilder($this->em->getConnection());
        $qb->from('"order"', 'o')
            ->select('o.id, o.customer_id, o.created_at')
            ->addSelect('(SELECT SUM(i.price * i.quantity - i.discount) FROM order_item i WHERE i.order_id = o.id) total_sum')
            ->addSelect('(SELECT COUNT(i.id) FROM order_item i WHERE i.order_id = o.id) count_items')
            ->where('o.customer_id = :customerId')
            ->orderBy('o.created_at', 'DESC')
            ->setMaxResults($limit)
            ->setFirstResult($offset)
            ->setParameter('customerId', $customerId);

        $result = $qb->executeQuery();

        return array_map(function (array $data) {
            return new OrderReadModel(
                (string) $data['id'],
                (string) $data['customer_id'],
                new \DateTime((string) $data['created_at']),
                (float) $data['total_sum'],
                (int) $data['count_items'],
            );
        }, $result->fetchAllAssociative());
    }
}
