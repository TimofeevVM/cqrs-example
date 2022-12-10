<?php

declare(strict_types=1);

namespace Order\Domain;

interface OrderRepository
{
    /**
     * Сохранить Заказ.
     */
    public function persist(Order $order): void;

    /**
     * Найти заказ по идентификатору.
     */
    public function ofId(string $id): Order;
}
