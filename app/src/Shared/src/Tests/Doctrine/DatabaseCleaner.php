<?php

declare(strict_types=1);

namespace Shared\Tests\Doctrine;

use Doctrine\ORM\EntityManagerInterface;

interface DatabaseCleaner
{
    public function clear(EntityManagerInterface $entityManager): void;
}
