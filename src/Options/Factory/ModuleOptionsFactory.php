<?php

namespace ZfbUser\Options\Factory;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;
use ZfbUser\Options\ModuleOptions;
use ZfbUser\Module;

/**
 * Class ModuleOptionsFactory
 *
 * @package ZfbUser\Options\Factory
 */
class ModuleOptionsFactory implements FactoryInterface
{
    /**
     * @param \Interop\Container\ContainerInterface $container
     * @param string                                $requestedName
     * @param array|null                            $options
     *
     * @return object|\ZfbUser\Options\ModuleOptions
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $config = $container->get('Config');

        /** @var \Zend\Mvc\I18n\Translator $translator */
        $translator = $container->get('MvcTranslator');
        $currentLocale = $translator->getLocale();

        return new ModuleOptions($currentLocale, $config[ Module::CONFIG_KEY ]);
    }
}
