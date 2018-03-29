<?php

namespace ZfbUser\Service;

use ZfbUser\Options\ModuleOptionsInterface;
use ZfbUser\Mapper\LogMapperInterface;
use ZfbUser\Service\Event\AuthenticateEvent;
use ZfbUser\Entity\LogInterface;
use ZfbUser\Service\Event\LogoutEvent;

/**
 * Class LogService
 *
 * @package ZfbUser\Service
 */
class LogService
{
    /**
     * @var ModuleOptionsInterface
     */
    protected $moduleOptions;

    /**
     * @var LogMapperInterface
     */
    protected $logMapper;

    /**
     * LogService constructor.
     *
     * @param \ZfbUser\Options\ModuleOptionsInterface $moduleOptions
     * @param \ZfbUser\Mapper\LogMapperInterface      $logMapper
     */
    public function __construct(ModuleOptionsInterface $moduleOptions, LogMapperInterface $logMapper)
    {
        $this->moduleOptions = $moduleOptions;
        $this->logMapper = $logMapper;
    }

    /**
     * @param \ZfbUser\Service\Event\AuthenticateEvent $event
     *
     * @return null|\ZfbUser\Entity\LogInterface
     */
    public function logAuthenticateEvent(AuthenticateEvent $event): ?LogInterface
    {
        try {
            $class = $this->moduleOptions->getLogEntityClass();
            /** @var LogInterface $logEntity */
            $logEntity = new $class;
            $logEntity->setUser($event->getUser());
            $logEntity->setDatetime($event->getDatetime());
            $logEntity->setType($event->getType());
            $logEntity->setSuccess($event->isSuccess());
            $logEntity->setMessage($event->getMessage());

            $this->logMapper->beginTransaction();
            $this->logMapper->insert($logEntity);
            $this->logMapper->commit();

            return $logEntity;
        } catch (\Exception $ex) {
            $this->logMapper->rollback();
        }

        return null;
    }

    /**
     * @param \ZfbUser\Service\Event\LogoutEvent $event
     *
     * @return null|\ZfbUser\Entity\LogInterface
     */
    public function logLogoutEvent(LogoutEvent $event): ?LogInterface
    {
        try {
            $class = $this->moduleOptions->getLogEntityClass();
            /** @var LogInterface $logEntity */
            $logEntity = new $class;
            $logEntity->setUser($event->getUser());
            $logEntity->setDatetime($event->getDatetime());
            $logEntity->setType($event->getType());
            $logEntity->setSuccess($event->isSuccess());
            $logEntity->setMessage($event->getMessage());

            $this->logMapper->beginTransaction();
            $this->logMapper->insert($logEntity);
            $this->logMapper->commit();

            return $logEntity;
        } catch (\Exception $ex) {
            $this->logMapper->rollback();
        }

        return null;

    }

}
