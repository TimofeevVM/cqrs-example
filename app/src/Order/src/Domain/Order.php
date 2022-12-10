<?php

declare(strict_types=1);

namespace Order\Domain;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class Order
{
    public readonly \DateTime $createdAt;
    /**
     * @psalm-var Collection<int, OrderItem>
     *
     * @var Collection<int, OrderItem>
     */
    private Collection $items;

    public function __construct(
        public readonly string $id,
        public readonly string $customerId
    ) {
        $this->createdAt = new \DateTime();
        $this->items = new ArrayCollection();
    }

    public static function create(string $customerId): Order
    {
        return new self(
            uniqid('order_'),
            $customerId,
        );
    }

    public function getTotal(): float
    {
        $sum = 0;

        foreach ($this->items as $item) {
            $sum += $item->getTotalPrice();
        }

        return (float) $sum;
    }

    public function addItem(string $productId, float $price, float $quantity, float $discount): OrderItem
    {
        $item = new OrderItem(
            uniqid('pos'),
            $this,
            $productId,
            $quantity,
            $price,
            $discount
        );

        $this->items->add($item);

        return $item;
    }

    public function getCountItem(): int
    {
        return $this->items->count();
    }
}
