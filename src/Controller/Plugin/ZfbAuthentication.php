<?php

namespace ZfbUser\Controller\Plugin;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;
use ZfbUser\Entity\UserInterface;
use ZfbUser\Service\AuthenticationService;

/**
 * Class ZfbAuthentication
 *
 * @package ZfbUser\Controller\Plugin
 */
class ZfbAuthentication extends AbstractPlugin
{
    /**
     * @var AuthenticationService
     */
    private $authService;

    /**
     * ZfbAuthentication constructor.
     *
     * @param \ZfbUser\Service\AuthenticationService $authService
     */
    public function __construct(AuthenticationService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * @return bool
     */
    public function hasIdentity(): bool
    {
        return $this->authService->hasIdentity();
    }

    /**
     * @return null|\ZfbUser\Entity\UserInterface
     */
    public function getIdentity(): ?UserInterface
    {
        return $this->authService->getIdentity();
    }

    /**
     * @return \ZfbUser\Service\AuthenticationService
     */
    public function getAuthService(): AuthenticationService
    {
        return $this->authService;
    }
}
