<?php

namespace ZfbUser\View\Helper\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use ZfbUser\Options\ModuleOptions;
use ZfbUser\View\Helper\AuthenticationWidget;

/**
 * Class AuthenticationWidgetFactory
 *
 * @package ZfbUser\View\Helper\Factory
 */
class AuthenticationWidgetFactory implements FactoryInterface
{
    /**
     * @param \Interop\Container\ContainerInterface $container
     * @param string                                $requestedName
     * @param array|null                            $options
     *
     * @return \ZfbUser\View\Helper\AuthenticationWidget
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        /** @var \Zend\Form\Form $form */
        $form = $container->get('zfbuser_authentication_form');

        /** @var ModuleOptions $moduleOptions */
        $moduleOptions = $container->get(ModuleOptions::class);
        $tpl = $moduleOptions->getAuthenticationWidgetViewTpl();

        $widget = new AuthenticationWidget($form, $tpl);

        return $widget;
    }
}
