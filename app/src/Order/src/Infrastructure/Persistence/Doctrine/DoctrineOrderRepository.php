<?php

declare(strict_types=1);

namespace Order\Infrastructure\Persistence\Doctrine;

use Order\Domain\Order;
use Order\Domain\OrderException;
use Order\Domain\OrderRepository;
use Shared\Doctrine\DoctrineRepository;

/**
 * @extends DoctrineRepository<Order>
 */
class DoctrineOrderRepository extends DoctrineRepository implements OrderRepository
{
    public function persist(Order $order): void
    {
        $this->persistAndFlush($order);
    }

    public function ofId(string $id): Order
    {
        $order = $this->repository()->find($id);

        if ($order instanceof Order) {
            return $order;
        }

        throw new OrderException(sprintf('Order with id %s not found', $id));
    }

    public function getEntityName(): string
    {
        return Order::class;
    }
}
