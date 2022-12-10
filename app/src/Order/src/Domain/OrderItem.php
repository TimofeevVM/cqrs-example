<?php

declare(strict_types=1);

namespace Order\Domain;

class OrderItem
{
    public function __construct(
        public readonly string $id,
        public readonly Order $order,
        public readonly string $productId,
        public readonly float $price,
        public readonly float $quantity,
        public readonly float $discount = 0,
    ) {
    }

    public function getTotalPrice(): float
    {
        return $this->price * $this->quantity - $this->discount;
    }
}
