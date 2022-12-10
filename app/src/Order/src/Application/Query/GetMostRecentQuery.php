<?php

declare(strict_types=1);

namespace Order\Application\Query;

use Shared\Bus\Command\Command;

class GetMostRecentQuery implements Command
{
    public function __construct(
        public readonly string $costumerId,
        public readonly int $limit,
        public readonly int $offset,
    ) {
    }
}
