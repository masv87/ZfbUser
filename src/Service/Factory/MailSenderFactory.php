<?php

namespace ZfbUser\Service\Factory;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;
use ZfbUser\Service\MailSender;
use ZfbUser\Options\ModuleOptions;
use Zend\Mail\Transport\TransportInterface;

/**
 * Class MailSenderFactory
 *
 * @package ZfbUser\Service\Factory
 */
class MailSenderFactory implements FactoryInterface
{
    /**
     * @param \Interop\Container\ContainerInterface $container
     * @param string                                $requestedName
     * @param array|null                            $options
     *
     * @return object|\ZfbUser\Service\MailSender
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        /** @var ModuleOptions $moduleOptions */
        $moduleOptions = $container->get(ModuleOptions::class);

        /** @var TransportInterface $transport */
        $transport = $container->get('zfbuser_mail_sender_transport');

        return new MailSender($moduleOptions->getMailSenderOptions(), $transport);
    }
}
