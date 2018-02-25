<?php

namespace ZfbUser\Form\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use ZfbUser\Form\RecoverPasswordForm;
use ZfbUser\Options\ModuleOptions;

/**
 * Class RecoverPasswordFormFactory
 *
 * @package ZfbUser\Form\Factory
 */
class RecoverPasswordFormFactory implements FactoryInterface
{
    /**
     * @param \Interop\Container\ContainerInterface $container
     * @param string                                $requestedName
     * @param array|null                            $options
     *
     * @return object|\ZfbUser\Form\RecoverPasswordForm
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        /** @var ModuleOptions $moduleOptions */
        $moduleOptions = $container->get(ModuleOptions::class);
        $formOptions = $moduleOptions->getRecoverPasswordFormOptions();
        $recaptchaOptions = $moduleOptions->getRecaptchaOptions();

        $form = new RecoverPasswordForm($formOptions, $recaptchaOptions);

        return $form;
    }
}
