<?php

declare(strict_types=1);

namespace Order\Application\Command;

use Shared\Bus\Command\Command;

class CreateOrderCommand implements Command
{
    /**
     * @param array<int, array> $items
     */
    public function __construct(
        public readonly string $costumerId,
        public readonly array $items,
    ) {
    }
}
