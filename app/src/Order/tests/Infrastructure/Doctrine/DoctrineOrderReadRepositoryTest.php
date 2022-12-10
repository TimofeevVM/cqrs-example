<?php

declare(strict_types=1);

namespace Tests\Infrastructure\Doctrine;

use Doctrine\ORM\EntityManagerInterface;
use Order\Domain\Order;
use Order\Infrastructure\Persistence\Doctrine\DoctrineOrderRepository;
use Order\Infrastructure\Query\Doctrine\DoctrineOrderReadRepository;
use Shared\Tests\PhpUnit\InfrastructureTestCase;

class OrderReadModalTest extends InfrastructureTestCase
{
    protected EntityManagerInterface $em;

    protected function setUp(): void
    {
        parent::setUp();

        $this->em = $this->get(EntityManagerInterface::class);
    }

    public function testOrderReadModel(): void
    {
        $persistenceRepository = new DoctrineOrderRepository($this->em);
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

        $persistenceRepository->persist($order);
        $persistenceRepository->em()->getUnitOfWork()->clear();

        $readRepository = new DoctrineOrderReadRepository($this->em);
        $firstOrder = current($readRepository->getMostRecent('customer-1', 1, 0));

        $this->assertSame($order->id, $firstOrder->id);
        $this->assertSame($order->customerId, $firstOrder->customerId);
        $this->assertSame($order->createdAt->getTimestamp(), $firstOrder->createdAt->getTimestamp());
        $this->assertSame($order->getCountItem(), $firstOrder->countItems);
        $this->assertSame($order->getTotal(), $firstOrder->totalSum);
    }
}
