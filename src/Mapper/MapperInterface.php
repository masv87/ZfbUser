<?php

namespace ZfbUser\Mapper;

/**
 * Interface MapperInterface
 *
 * @package ZfbUser\Mapper
 */
interface MapperInterface
{
    /**
     * Starts a transaction on the underlying database connection.
     *
     * @return void
     */
    public function beginTransaction(): void;

    /**
     * Commits a transaction on the underlying database connection.
     *
     * @return void
     */
    public function commit(): void;

    /**
     * Performs a rollback on the underlying database connection.
     *
     * @return void
     */
    public function rollback(): void;
}
