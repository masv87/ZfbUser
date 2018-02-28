<?php

namespace ZfbUser\Form\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use ZfbUser\Form\SetPasswordForm;
use ZfbUser\Options\ModuleOptions;

/**
 * Class SetPasswordFormFactory
 *
 * @package ZfbUser\Form\Factory
 */
class SetPasswordFormFactory implements FactoryInterface
{
    /**
     * @param \Interop\Container\ContainerInterface $container
     * @param string                                $requestedName
     * @param array|null                            $options
     *
     * @return object|\ZfbUser\Form\SetPasswordForm
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        /** @var ModuleOptions $moduleOptions */
        $moduleOptions = $container->get(ModuleOptions::class);
        $formOptions = $moduleOptions->getSetPasswordFormOptions();
        $recaptchaOptions = $moduleOptions->getRecaptchaOptions();

        $form = new SetPasswordForm($formOptions, $recaptchaOptions);

        return $form;
    }
}
