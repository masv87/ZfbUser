<?php

namespace ZfbUser\Controller\Plugin\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use ZfbUser\Controller\Plugin\ZfbAuthentication as ZfbAuthenticationPlugin;
use ZfbUser\Service\AuthenticationService;

/**
 * Class ZfbAuthenticationFactory
 *
 * @package ZfbUser\Controller\Plugin\Factory
 */
class ZfbAuthenticationFactory implements FactoryInterface
{
    /**
     * @param \Interop\Container\ContainerInterface $container
     * @param string                                $requestedName
     * @param array|null                            $options
     *
     * @return object|\ZfbUser\Controller\Plugin\ZfbAuthentication
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        /** @var AuthenticationService $authService */
        $authService = $container->get(\Zend\Authentication\AuthenticationService::class);

        $controllerPlugin = new ZfbAuthenticationPlugin($authService);

        return $controllerPlugin;
    }
}
