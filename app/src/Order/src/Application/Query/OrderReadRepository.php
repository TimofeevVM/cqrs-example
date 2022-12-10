<?php

declare(strict_types=1);

namespace Order\Application\Query;

interface OrderReadRepository
{
    /**
     * Получить последние заказы.
     *
     * @return OrderReadModel[]
     */
    public function getMostRecent(string $customerId, int $limit, int $offset): array;
}
