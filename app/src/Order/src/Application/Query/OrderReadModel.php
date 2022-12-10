<?php

declare(strict_types=1);

namespace Order\Application\Query;

class OrderReadModel
{
    public function __construct(
        public readonly string $id,
        public readonly string $customerId,
        public readonly \DateTime $createdAt,
        public readonly float $totalSum,
        public readonly int $countItems
    ) {
    }
}
