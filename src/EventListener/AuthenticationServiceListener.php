<?php

namespace ZfbUser\EventListener;

use ZfbUser\Service\Event\LogoutEvent;
use ZfbUser\Service\LogService;
use ZfbUser\Service\Event\AuthenticateEvent;

/**
 * Class AuthenticationServiceListener
 *
 * @package ZfbUser\EventListener
 */
class AuthenticationServiceListener
{
    /**
     * @var LogService
     */
    protected $logService;

    /**
     * AuthenticationServiceListener constructor.
     *
     * @param \ZfbUser\Service\LogService $logService
     */
    public function __construct(LogService $logService)
    {
        $this->logService = $logService;
    }

    /**
     * @param \ZfbUser\Service\Event\AuthenticateEvent $event
     */
    public function onAuthenticatePre(AuthenticateEvent $event)
    {
        $this->logService->logAuthenticateEvent($event);
    }

    /**
     * @param \ZfbUser\Service\Event\AuthenticateEvent $event
     */
    public function onAuthenticatePost(AuthenticateEvent $event)
    {
        $this->logService->logAuthenticateEvent($event);
    }

    /**
     * @param \ZfbUser\Service\Event\AuthenticateEvent $event
     */
    public function onAuthenticateError(AuthenticateEvent $event)
    {
        $this->logService->logAuthenticateEvent($event);
    }

    /**
     * @param \ZfbUser\Service\Event\LogoutEvent $event
     */
    public function onLogoutPre(LogoutEvent $event)
    {
        $this->logService->logLogoutEvent($event);
    }
}
