<?php

namespace ZfbUser\Service\Factory;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;
use ZfbUser\Service\UserService;
use ZfbUser\Options\ModuleOptions;
use ZfbUser\Service\MailSender;
use ZfbUser\Service\TokenService;

/**
 * Class UserServiceFactory
 *
 * @package ZfbUser\Service\Factory
 */
class UserServiceFactory implements FactoryInterface
{
    /**
     * @param \Interop\Container\ContainerInterface $container
     * @param string                                $requestedName
     * @param array|null                            $options
     *
     * @return object|\ZfbUser\Service\UserService
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        /** @var \ZfbUser\Adapter\AdapterInterface $authAdapter */
        $authAdapter = $container->get('zfbuser_authentication_adapter');

        /** @var ModuleOptions $moduleOptions */
        $moduleOptions = $container->get(ModuleOptions::class);

        /** @var MailSender $mailSender */
        $mailSender = $container->get(MailSender::class);

        /** @var TokenService $tokenService */
        $tokenService = $container->get(TokenService::class);

        return new UserService($authAdapter, $moduleOptions, $mailSender, $tokenService);
    }
}
