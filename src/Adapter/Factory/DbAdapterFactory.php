<?php

namespace ZfbUser\Adapter\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use ZfbUser\Adapter\DbAdapter;
use ZfbUser\Mapper\UserMapperInterface;
use ZfbUser\Options\ModuleOptions;
use ZfbUser\Repository\UserRepositoryInterface;

/**
 * Class DbAdapterFactory
 *
 * @package ZfbUser\Adapter\Factory
 */
class DbAdapterFactory implements FactoryInterface
{
    /**
     * @param \Interop\Container\ContainerInterface $container
     * @param string                                $requestedName
     * @param array|null                            $options
     *
     * @return object|\ZfbUser\Adapter\DbAdapter
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        /** @var ModuleOptions $moduleOptions */
        $moduleOptions = $container->get(ModuleOptions::class);

        /** @var UserMapperInterface $mapper */
        $mapper = $container->get('zfbuser_user_mapper');

        /** @var UserRepositoryInterface $repository */
        $repository = $container->get('zfbuser_user_repository');

        $adapter = new DbAdapter($moduleOptions, $mapper, $repository);

        return $adapter;
    }
}
