<?php

declare(strict_types=1);

namespace Order\Application\Query;

use Shared\Bus\Query\QueryResponse;

class GetMostRecentResponse implements QueryResponse
{
    /**
     * @param OrderReadModel[] $orders
     */
    public function __construct(
        public readonly array $orders
    ) {
    }
}
