<?php

declare(strict_types=1);

namespace Order\Application\Command;

use Order\Domain\Order;
use Order\Domain\OrderRepository;
use Shared\Bus\Command\CommandHandler;

class CreateOrderHandler implements CommandHandler
{
    public function __construct(
        private readonly OrderRepository $orderRepository
    ) {
    }

    public function __invoke(CreateOrderCommand $command)
    {
        $order = Order::create($command->costumerId);

        foreach ($command->items as $item) {
            if (isset($item['id'])
                && isset($item['price'])
                && isset($item['quantity'])
                && isset($item['discount'])
            ) {
                $order->addItem(
                    (string) $item['id'],
                    (float) $item['price'],
                    (int) $item['quantity'],
                    (float) $item['discount'],
                );
            }
        }

        $this->orderRepository->persist($order);
    }
}
