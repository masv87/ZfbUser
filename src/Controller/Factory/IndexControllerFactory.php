<?php

namespace ZfbUser\Controller\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use ZfbUser\Controller\IndexController;
use ZfbUser\Options\ModuleOptions;

/**
 * Class IndexControllerFactory
 *
 * @package ZfbUser\Controller\Factory
 */
class IndexControllerFactory implements FactoryInterface
{
    /**
     * @param \Interop\Container\ContainerInterface $container
     * @param string                                $requestedName
     * @param array|null                            $options
     *
     * @return object|\ZfbUser\Controller\IndexController
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        /** @var ModuleOptions $moduleOptions */
        $moduleOptions = $container->get(ModuleOptions::class);

        return new IndexController($moduleOptions);
    }
}
