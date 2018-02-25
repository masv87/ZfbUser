<?php

namespace ZfbUser\Service\Factory;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;
use ZfbUser\Repository\TokenRepositoryInterface;
use ZfbUser\Mapper\TokenMapperInterface;
use ZfbUser\Service\TokenService;
use ZfbUser\Options\ModuleOptions;

/**
 * Class TokenServiceFactory
 *
 * @package ZfbUser\Service\Factory
 */
class TokenServiceFactory implements FactoryInterface
{
    /**
     * @param \Interop\Container\ContainerInterface $container
     * @param string                                $requestedName
     * @param array|null                            $options
     *
     * @return object|\ZfbUser\Service\TokenService
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        /** @var TokenRepositoryInterface $repository */
        $repository = $container->get('zfbuser_token_repository');

        /** @var TokenMapperInterface $mapper */
        $mapper = $container->get('zfbuser_token_mapper');

        /** @var ModuleOptions $moduleOptions */
        $moduleOptions = $container->get(ModuleOptions::class);

        return new TokenService($repository, $mapper, $moduleOptions);
    }
}
