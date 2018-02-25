<?php

namespace ZfbUser\View\Helper;

use Zend\View\Helper\AbstractHelper;
use ZfbUser\Service\AuthenticationService;
use ZfbUser\Entity\UserInterface;

/**
 * Class UserIdentity
 *
 * @package ZfbUser\View\Helper
 */
class UserIdentity extends AbstractHelper
{
    /**
     * @var AuthenticationService
     */
    private $authService;

    /**
     * UserIdentity constructor.
     *
     * @param \ZfbUser\Service\AuthenticationService $authService
     */
    public function __construct(AuthenticationService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * @return UserInterface|null
     */
    public function __invoke()
    {
        if ($this->authService->hasIdentity()) {
            return $this->authService->getIdentity();
        }

        return null;
    }
}
