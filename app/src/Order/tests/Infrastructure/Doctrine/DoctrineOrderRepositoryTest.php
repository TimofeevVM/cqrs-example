<?php

declare(strict_types=1);

namespace Tests\Infrastructure\Doctrine;

use Doctrine\ORM\EntityManagerInterface;
use Order\Domain\Order;
use Order\Infrastructure\Persistence\Doctrine\DoctrineOrderRepository;
use Shared\Tests\PhpUnit\InfrastructureTestCase;

class OrderItemTest extends InfrastructureTestCase
{
    protected EntityManagerInterface $em;

    protected function setUp(): void
    {
        parent::setUp();

        $this->em = $this->get(EntityManagerInterface::class);
    }

    public function testOrderPersistence(): void
    {
        $repository = new DoctrineOrderRepository($this->em);
        $order = new Order(
            'order-1',
            'customer-1',
            []
        );
        $repository->persist($order);
        $repository->em()->getUnitOfWork()->clear();
        $dbOrder = $repository->ofId('order-1');

        $this->assertSame($order->id, $dbOrder->id);
        $this->assertSame($order->customerId, $dbOrder->customerId);
        $this->assertSame($order->createdAt->getTimestamp(), $dbOrder->createdAt->getTimestamp());
    }

    public function testOrderWithItemsPersistence(): void
    {
        $repository = new DoctrineOrderRepository($this->em);
        $order = new Order(
            'order-1',
            'customer-1'
        );
        $order->addItem(
            'p1',
            200,
            1,
            0
        );
        $order->addItem(
            'p2',
            250,
            2,
            0
        );
        $order->addItem(
            'p2',
            250,
            1,
            50
        );

        $repository->persist($order);
        $repository->em()->getUnitOfWork()->clear();
        $dbOrder = $repository->ofId('order-1');

        $this->assertSame($order->id, $dbOrder->id);
        $this->assertSame($order->customerId, $dbOrder->customerId);
        $this->assertSame($order->createdAt->getTimestamp(), $dbOrder->createdAt->getTimestamp());
        $this->assertSame($order->getCountItem(), $dbOrder->getCountItem());
    }
}
