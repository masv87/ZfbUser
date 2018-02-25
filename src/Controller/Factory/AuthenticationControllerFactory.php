<?php

namespace ZfbUser\Controller\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use ZfbUser\Adapter\AdapterInterface;
use ZfbUser\Controller\AuthenticationController;
use ZfbUser\Form\AuthenticationForm;
use ZfbUser\Options\ModuleOptions;

/**
 * Class AuthenticationControllerFactory
 *
 * @package ZfbUser\Controller\Factory
 */
class AuthenticationControllerFactory implements FactoryInterface
{
    /**
     * @param \Interop\Container\ContainerInterface $container
     * @param string                                $requestedName
     * @param array|null                            $options
     *
     * @return object|\ZfbUser\Controller\AuthenticationController
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        /** @var ModuleOptions $moduleOptions */
        $moduleOptions = $container->get(ModuleOptions::class);

        /** @var AuthenticationForm $form */
        $form = $container->get('zfbuser_authentication_form');

        /** @var AdapterInterface $adapter */
        $adapter = $container->get('zfbuser_authentication_adapter');

        return new AuthenticationController($form, $adapter, $moduleOptions);
    }
}
