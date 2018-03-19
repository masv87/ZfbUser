<?php

namespace ZfbUser\Controller\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use ZfbUser\Controller\UserController;
use ZfbUser\Options\ModuleOptions;
use ZfbUser\Repository\UserRepositoryInterface;

/**
 * Class UserControllerFactory
 *
 * @package ZfbUser\Controller\Factory
 */
class UserControllerFactory implements FactoryInterface
{
    /**
     * @param \Interop\Container\ContainerInterface $container
     * @param string                                $requestedName
     * @param array|null                            $options
     *
     * @return object|\ZfbUser\Controller\UserController
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        /** @var ModuleOptions $moduleOptions */
        $moduleOptions = $container->get(ModuleOptions::class);

        /** @var UserRepositoryInterface $repository */
        $repository = $container->get('zfbuser_user_repository');

        return new UserController($moduleOptions, $repository);
    }
}
