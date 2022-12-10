<?php

declare(strict_types=1);

namespace Tests\Order\Domain;

use Order\Domain\Order;
use PHPUnit\Framework\TestCase;

class OrderTest extends TestCase
{
    public function testTotal(): void
    {
        $order = new Order('order-1', 'customer-1');
        $order->addItem(
            'pos-1',
            200,
            1,
            0
        );
        $order->addItem(
            'pos-1',
            200,
            2,
            0
        );
        $order->addItem(
            'pos-1',
            200,
            4,
            200
        );

        $this->assertSame(1200.0, $order->getTotal());
    }
}
