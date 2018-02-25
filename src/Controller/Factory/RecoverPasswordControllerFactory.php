<?php

namespace ZfbUser\Controller\Factory;

use Interop\Container\ContainerInterface;
use Zend\Form\Form;
use Zend\ServiceManager\Factory\FactoryInterface;
use ZfbUser\Controller\RecoverPasswordController;
use ZfbUser\Options\ModuleOptions;
use ZfbUser\Service\UserService;

/**
 * Class RecoverPasswordControllerFactory
 *
 * @package ZfbUser\Controller\Factory
 */
class RecoverPasswordControllerFactory implements FactoryInterface
{
    /**
     * @param \Interop\Container\ContainerInterface $container
     * @param string                                $requestedName
     * @param array|null                            $options
     *
     * @return object|\ZfbUser\Controller\RecoverPasswordController
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        /** @var Form $form */
        $recoverForm = $container->get('zfbuser_recover_password_form');

        /** @var Form $form */
        $changeForm = $container->get('zfbuser_change_password_form');

        /** @var UserService $userService */
        $userService = $container->get(UserService::class);

        /** @var ModuleOptions $moduleOptions */
        $moduleOptions = $container->get(ModuleOptions::class);

        return new RecoverPasswordController($recoverForm, $changeForm, $userService, $moduleOptions);
    }
}
