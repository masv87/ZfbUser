<?php

namespace ZfbUser\Form\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use ZfbUser\Form\AuthenticationForm;
use ZfbUser\Options\ModuleOptions;

/**
 * Class AuthenticationFormFactory
 *
 * @package ZfbUser\Form\Factory
 */
class AuthenticationFormFactory implements FactoryInterface
{
    /**
     * @param \Interop\Container\ContainerInterface $container
     * @param string                                $requestedName
     * @param array|null                            $options
     *
     * @return object|\ZfbUser\Form\AuthenticationForm
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        /** @var ModuleOptions $moduleOptions */
        $moduleOptions = $container->get(ModuleOptions::class);
        $formOptions = $moduleOptions->getAuthenticationFormOptions();
        $recaptchaOptions = $moduleOptions->getRecaptchaOptions();

        $form = new AuthenticationForm($formOptions, $recaptchaOptions);

        return $form;
    }
}
