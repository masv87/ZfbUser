<?php

namespace ZfbUser\Controller\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use ZfbUser\Controller\ConfirmationController;
use ZfbUser\Options\ModuleOptions;
use ZfbUser\Service\UserService;

/**
 * Class ConfirmationControllerFactory
 *
 * @package ZfbUser\Controller\Factory
 */
class ConfirmationControllerFactory implements FactoryInterface
{
    /**
     * @param \Interop\Container\ContainerInterface $container
     * @param string                                $requestedName
     * @param array|null                            $options
     *
     * @return object|\ZfbUser\Controller\ConfirmationController
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        /** @var UserService $userService */
        $userService = $container->get(UserService::class);

        /** @var ModuleOptions $moduleOptions */
        $moduleOptions = $container->get(ModuleOptions::class);

        return new ConfirmationController($userService, $moduleOptions);
    }
}
