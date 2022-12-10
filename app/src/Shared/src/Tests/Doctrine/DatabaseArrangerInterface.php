<?php

declare(strict_types=1);

namespace Shared\Tests\Doctrine;

interface DatabaseArrangerInterface
{
    public function beforeClass(): void;

    public function afterClass(): void;

    public function beforeTest(): void;

    public function afterTest(): void;
}
