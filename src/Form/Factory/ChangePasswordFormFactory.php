<?php

namespace ZfbUser\Form\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use ZfbUser\Form\ChangePasswordForm;
use ZfbUser\Options\ModuleOptions;

/**
 * Class ChangePasswordFormFactory
 *
 * @package ZfbUser\Form\Factory
 */
class ChangePasswordFormFactory implements FactoryInterface
{
    /**
     * @param \Interop\Container\ContainerInterface $container
     * @param string                                $requestedName
     * @param array|null                            $options
     *
     * @return object|\ZfbUser\Form\ChangePasswordForm
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        /** @var ModuleOptions $moduleOptions */
        $moduleOptions = $container->get(ModuleOptions::class);
        $formOptions = $moduleOptions->getChangePasswordFormOptions();
        $recaptchaOptions = $moduleOptions->getRecaptchaOptions();

        $form = new ChangePasswordForm($formOptions, $recaptchaOptions);

        return $form;
    }
}
