<?php

namespace ZfbUser\View\Helper\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use ZfbUser\Service\AuthenticationService;
use ZfbUser\View\Helper\UserDisplayName;

/**
 * Class UserDisplayNameFactory
 *
 * @package ZfbUser\View\Helper\Factory
 */
class UserDisplayNameFactory implements FactoryInterface
{
    /**
     * @param \Interop\Container\ContainerInterface $container
     * @param string                                $requestedName
     * @param array|null                            $options
     *
     * @return \ZfbUser\View\Helper\UserDisplayName
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        /** @var AuthenticationService $authService */
        $authService = $container->get(\Zend\Authentication\AuthenticationService::class);
        $widget = new UserDisplayName($authService);

        return $widget;
    }
}
