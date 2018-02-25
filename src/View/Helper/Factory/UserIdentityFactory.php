<?php

namespace ZfbUser\View\Helper\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use ZfbUser\Service\AuthenticationService;
use ZfbUser\View\Helper\UserIdentity;

/**
 * Class UserIdentityFactory
 *
 * @package ZfbUser\View\Helper\Factory
 */
class UserIdentityFactory implements FactoryInterface
{
    /**
     * @param \Interop\Container\ContainerInterface $container
     * @param string                                $requestedName
     * @param array|null                            $options
     *
     * @return \ZfbUser\View\Helper\UserIdentity
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        /** @var AuthenticationService $authService */
        $authService = $container->get(\Zend\Authentication\AuthenticationService::class);
        $widget = new UserIdentity($authService);

        return $widget;
    }
}
