<?php

namespace ZfbUser\EventListener\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use ZfbUser\Service\LogService;
use ZfbUser\EventListener\AuthenticationServiceListener;

/**
 * Class AuthenticationServiceListenerFactory
 *
 * @package ZfbUser\EventListener\Factory
 */
class AuthenticationServiceListenerFactory implements FactoryInterface
{
    /**
     * @param \Interop\Container\ContainerInterface $container
     * @param string                                $requestedName
     * @param array|null                            $options
     *
     * @return object|\ZfbUser\EventListener\AuthenticationServiceListener
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        /** @var LogService $logService */
        $logService = $container->get(LogService::class);

        $listener = new AuthenticationServiceListener($logService);

        return $listener;
    }
}
