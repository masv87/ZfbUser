<?php

namespace ZfbUser\Mapper;

use ZfbUser\Entity\LogInterface;

/**
 * Interface LogMapperInterface
 *
 * @package ZfbUser\Mapper
 */
interface LogMapperInterface extends MapperInterface
{
    /**
     * @param LogInterface $log
     *
     * @return LogInterface
     */
    public function insert(LogInterface $log): LogInterface;

    /**
     * @param LogInterface $log
     *
     * @return LogInterface
     */
    public function update(LogInterface $log): LogInterface;
}
