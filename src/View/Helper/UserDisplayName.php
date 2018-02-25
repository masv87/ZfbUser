<?php

namespace ZfbUser\View\Helper;

use Zend\View\Helper\AbstractHelper;
use ZfbUser\Service\AuthenticationService;
use ZfbUser\Entity\UserInterface;

/**
 * Class UserDisplayName
 *
 * @package ZfbUser\View\Helper
 */
class UserDisplayName extends AbstractHelper
{
    /**
     * @var AuthenticationService
     */
    private $authService;

    /**
     * UserDisplayName constructor.
     *
     * @param \ZfbUser\Service\AuthenticationService $authService
     */
    public function __construct(AuthenticationService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * @return string
     */
    public function __invoke()
    {
        if ($this->authService->hasIdentity()) {
            /** @var UserInterface $identity */
            $identity = $this->authService->getIdentity();

            return $identity->getDisplayName();
        }

        return '';
    }
}
