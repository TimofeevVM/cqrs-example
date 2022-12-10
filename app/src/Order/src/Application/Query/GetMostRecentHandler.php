<?php

declare(strict_types=1);

namespace Order\Application\Query;

use Shared\Bus\Query\QueryHandler;

class GetMostRecentHandler implements QueryHandler
{
    public function __construct(
        private readonly OrderReadRepository $orderReadRepository
    ) {
    }

    public function __invoke(GetMostRecentQuery $query): GetMostRecentResponse
    {
        return new GetMostRecentResponse(
            $this->orderReadRepository->getMostRecent($query->costumerId, $query->limit, $query->offset)
        );
    }
}
