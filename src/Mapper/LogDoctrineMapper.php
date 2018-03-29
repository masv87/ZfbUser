<?php

namespace ZfbUser\Mapper;

use ZfbUser\Entity\LogInterface;

/**
 * Class LogDoctrineMapper
 *
 * @package ZfbUser\Mapper
 */
class LogDoctrineMapper extends DoctrineMapper implements LogMapperInterface
{
    /**
     * @param LogInterface $log
     *
     * @return LogInterface
     */
    public function insert(LogInterface $log): LogInterface
    {
        return $this->saveLog($log);
    }

    /**
     * @param LogInterface $log
     *
     * @return LogInterface
     */
    public function update(LogInterface $log): LogInterface
    {
        return $this->saveLog($log);
    }

    /**
     * @param \ZfbUser\Entity\LogInterface $log
     *
     * @return \ZfbUser\Entity\LogInterface
     */
    private function saveLog(LogInterface $log): LogInterface
    {
        $this->entityManager->persist($log);
        $this->entityManager->flush();

        return $log;
    }
}
