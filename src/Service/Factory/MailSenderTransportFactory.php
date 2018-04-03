<?php

namespace ZfbUser\Service\Factory;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;
use Zend\Mail\Transport\TransportInterface;
use ZfbUser\Options\ModuleOptions;

/**
 * Class MailSenderTransportFactory
 *
 * @package ZfbUser\Service\Factory
 */
class MailSenderTransportFactory implements FactoryInterface
{
    /**
     * @param \Interop\Container\ContainerInterface $container
     * @param string                                $requestedName
     * @param array|null                            $options
     *
     * @return object|\Zend\Mail\Transport\TransportInterface
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        /** @var ModuleOptions $moduleOptions */
        $moduleOptions = $container->get(ModuleOptions::class);

        /** @var TransportInterface $transport */
        $transport = $container->get($moduleOptions->getMailSenderOptions()->getTransportFactory());

        return $transport;
    }
}
