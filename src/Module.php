<?php

namespace ZfbUser;

use Zend\Mvc\MvcEvent;
use Zend\Validator\AbstractValidator;

/**
 * Class Module
 *
 * @package ZfbUser
 */
class Module
{
    const VERSION = '1.0';

    const CONFIG_KEY = 'zfb_user';

    /**
     * @param \Zend\Mvc\MvcEvent $e
     *
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function onBootstrap(MvcEvent $e)
    {
        AbstractValidator::setDefaultTranslator($e->getApplication()->getServiceManager()->get('MvcTranslator'));
    }

    /**
     * @return array
     */
    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }
}
