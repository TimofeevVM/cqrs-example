<?php

declare(strict_types=1);

namespace Shared\Doctrine;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\Persistence\ObjectRepository;

/**
 * @template TEntity of object
 */
abstract class DoctrineRepository
{
    public function __construct(
        private readonly EntityManagerInterface $em
    ) {
    }

    /**
     * @psalm-return class-string<TEntity>
     */
    abstract public function getEntityName(): string;

    public function em(): EntityManagerInterface
    {
        return $this->em;
    }

    /**
     * @param TEntity $entity
     *
     * @psalm-suppress TooManyArguments
     */
    protected function persistAndFlush(object $entity): void
    {
        $this->em()->persist($entity);
        $this->em()->flush($entity);
    }

    /**
     * @return EntityRepository<TEntity>|ObjectRepository<TEntity>
     */
    protected function repository(): EntityRepository|ObjectRepository
    {
        return $this->em()
            ->getRepository($this->getEntityName());
    }
}
