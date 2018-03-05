<?php

namespace ZfbUser\Controller\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Zend\Form\Form;
use ZfbUser\Controller\SetPasswordController;
use ZfbUser\Options\ModuleOptions;
use ZfbUser\Service\UserService;

/**
 * Class SetPasswordControllerFactory
 *
 * @package ZfbUser\Controller\Factory
 */
class SetPasswordControllerFactory implements FactoryInterface
{
    /**
     * @param \Interop\Container\ContainerInterface $container
     * @param string                                $requestedName
     * @param array|null                            $options
     *
     * @return object|\ZfbUser\Controller\SetPasswordController
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        /** @var UserService $userService */
        $userService = $container->get(UserService::class);

        /** @var Form $form */
        $setPasswordForm = $container->get('zfbuser_set_password_form');

        /** @var ModuleOptions $moduleOptions */
        $moduleOptions = $container->get(ModuleOptions::class);

        return new SetPasswordController($setPasswordForm, $userService, $moduleOptions);
    }
}
