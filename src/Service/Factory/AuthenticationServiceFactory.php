<?php

namespace ZfbUser\Service\Factory;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;
use Zend\Session\SessionManager;
use Zend\Session\Validator\HttpUserAgent;
use Zend\Session\Validator\RemoteAddr;
use ZfbUser\Service\AuthenticationService;
use Zend\Authentication\Storage\Session as SessionStorage;
use Zend\Session\Config\StandardConfig;
use ZfbUser\Options\ModuleOptions;

/**
 * Class AuthenticationServiceFactory
 *
 * @package ZfbUser\Service\Factory
 */
class AuthenticationServiceFactory implements FactoryInterface
{
    /**
     * @param \Interop\Container\ContainerInterface $container
     * @param string                                $requestedName
     * @param array|null                            $options
     *
     * @return \ZfbUser\Service\AuthenticationService
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        /** @var \ZfbUser\Adapter\AdapterInterface $authAdapter */
        $authAdapter = $container->get('zfbuser_authentication_adapter');

        /** @var ModuleOptions $moduleOptions */
        $moduleOptions = $container->get(ModuleOptions::class);

        $config = new StandardConfig();
        $config->setOptions([
            'remember_me_seconds' => $moduleOptions->getStorageTtl(),
            'validators'          => [
                RemoteAddr::class,
                HttpUserAgent::class,
            ],
        ]);
        $manager = new SessionManager($config);
        $storage = new SessionStorage('zfb_user', 'storage', $manager);
        $manager->rememberMe($moduleOptions->getStorageTtl());


        return new AuthenticationService($storage, $authAdapter);
    }
}
