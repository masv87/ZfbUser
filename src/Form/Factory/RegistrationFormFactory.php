<?php

namespace ZfbUser\Form\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use ZfbUser\Form\RegistrationForm;
use ZfbUser\Options\ModuleOptions;

/**
 * Class RegistrationFormFactory
 *
 * @package ZfbUser\Form\Factory
 */
class RegistrationFormFactory implements FactoryInterface
{
    /**
     * @param \Interop\Container\ContainerInterface $container
     * @param string                                $requestedName
     * @param array|null                            $options
     *
     * @return object|\ZfbUser\Form\RegistrationForm
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        /** @var ModuleOptions $moduleOptions */
        $moduleOptions = $container->get(ModuleOptions::class);
        $formOptions = $moduleOptions->getRegistrationFormOptions();
        $recaptchaOptions = $moduleOptions->getRecaptchaOptions();

        $form = new RegistrationForm($formOptions, $recaptchaOptions);

        return $form;
    }
}
