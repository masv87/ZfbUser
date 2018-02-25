<?php

namespace ZfbUser\Controller\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use ZfbUser\Controller\RegistrationController;
use ZfbUser\Form\RegistrationForm;
use ZfbUser\Options\ModuleOptions;
use ZfbUser\Service\UserService;

/**
 * Class RegistrationControllerFactory
 *
 * @package ZfbUser\Controller\Factory
 */
class RegistrationControllerFactory implements FactoryInterface
{
    /**
     * @param \Interop\Container\ContainerInterface $container
     * @param string                                $requestedName
     * @param array|null                            $options
     *
     * @return object|\ZfbUser\Controller\RegistrationController
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        /** @var UserService $userService */
        $userService = $container->get(UserService::class);

        /** @var RegistrationForm $form */
        $form = $container->get('zfbuser_registration_form');

        /** @var ModuleOptions $moduleOptions */
        $moduleOptions = $container->get(ModuleOptions::class);

        return new RegistrationController($userService, $form, $moduleOptions);
    }
}
