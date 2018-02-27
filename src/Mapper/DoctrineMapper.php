<?php

namespace ZfbUser\Mapper;

use Doctrine\ORM\EntityManagerInterface;

/**
 * Class DoctrineMapper
 *
 * Abstract class for Doctrine mappers
 *
 * @package ZfbUser\Mapper
 */
abstract class DoctrineMapper implements MapperInterface
{
    /**
     * @var EntityManagerInterface
     */
    protected $entityManager;

    /**
     * UserDoctrineMapper constructor.
     *
     * @param \Doctrine\ORM\EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @inheritdoc
     */
    public function beginTransaction(): void
    {
        $this->entityManager->beginTransaction();
    }

    /**
     * @inheritdoc
     */
    public function commit(): void
    {
        $this->entityManager->commit();
    }

    /**
     * @inheritdoc
     */
    public function rollback(): void
    {
        $this->entityManager->rollback();
    }
}
