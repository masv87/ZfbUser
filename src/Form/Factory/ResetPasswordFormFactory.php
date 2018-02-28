<?php

namespace ZfbUser\Form\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use ZfbUser\Form\ResetPasswordForm;
use ZfbUser\Options\ModuleOptions;

/**
 * Class ResetPasswordFormFactory
 *
 * @package ZfbUser\Form\Factory
 */
class ResetPasswordFormFactory implements FactoryInterface
{
    /**
     * @param \Interop\Container\ContainerInterface $container
     * @param string                                $requestedName
     * @param array|null                            $options
     *
     * @return object|\ZfbUser\Form\ResetPasswordForm
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        /** @var ModuleOptions $moduleOptions */
        $moduleOptions = $container->get(ModuleOptions::class);
        $formOptions = $moduleOptions->getResetPasswordFormOptions();
        $recaptchaOptions = $moduleOptions->getRecaptchaOptions();

        $form = new ResetPasswordForm($formOptions, $recaptchaOptions);

        return $form;
    }
}
