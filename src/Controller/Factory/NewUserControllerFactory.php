<?php

namespace ZfbUser\Controller\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Zend\Form\Form;
use ZfbUser\Controller\NewUserController;
use ZfbUser\Options\ModuleOptions;
use ZfbUser\Service\UserService;

/**
 * Class NewUserControllerFactory
 *
 * @package ZfbUser\Controller\Factory
 */
class NewUserControllerFactory implements FactoryInterface
{
    /**
     * @param \Interop\Container\ContainerInterface $container
     * @param string                                $requestedName
     * @param array|null                            $options
     *
     * @return object|\ZfbUser\Controller\NewUserController
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        /** @var UserService $userService */
        $userService = $container->get(UserService::class);

        /** @var Form $form */
        $newUserForm = $container->get('zfbuser_new_user_form');

        /** @var Form $form */
        $setPasswordForm = $container->get('zfbuser_set_password_form');

        /** @var ModuleOptions $moduleOptions */
        $moduleOptions = $container->get(ModuleOptions::class);

        return new NewUserController($newUserForm, $setPasswordForm, $userService, $moduleOptions);
    }
}
