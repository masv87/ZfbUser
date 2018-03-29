<?php

namespace ZfbUser\Service\Factory;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;
use ZfbUser\Service\LogService;
use ZfbUser\Mapper\LogMapperInterface;
use ZfbUser\Options\ModuleOptions;

/**
 * Class LogServiceFactory
 *
 * @package ZfbUser\Service\Factory
 */
class LogServiceFactory implements FactoryInterface
{
    /**
     * @param \Interop\Container\ContainerInterface $container
     * @param string                                $requestedName
     * @param array|null                            $options
     *
     * @return object|\ZfbUser\Service\LogService
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        /** @var ModuleOptions $moduleOptions */
        $moduleOptions = $container->get(ModuleOptions::class);

        /** @var LogMapperInterface $logMapper */
        $logMapper = $container->get('zfbuser_log_mapper');

        return new LogService($moduleOptions, $logMapper);
    }
}
