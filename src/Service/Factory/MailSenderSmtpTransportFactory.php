<?php

namespace ZfbUser\Service\Factory;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;
use Zend\Mail\Transport\Smtp as SmtpTransport;
use Zend\Mail\Transport\SmtpOptions;


/**
 * Class MailSenderSmtpTransportFactory
 * @package ZfbUser\Service\Factory
 */
class MailSenderSmtpTransportFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param array|null $options
     * @return object|SmtpTransport
     * @throws \Exception
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $config = $container->get('Config');
        if (empty($config['mail'])) {
            throw new \Exception('Config for "mail" not found.');
        }

        $options = [
            'name' => $config['mail']['name'],
            'host' => $config['mail']['host'],
            'port' => $config['mail']['port'],
        ];
        if (!empty($config['mail']['username']) && !empty($config['mail']['password'])) {
            $options = array_merge($options, [
                'connection_class' => 'login',
                'connection_config' => [
                    'username' => $config['mail']['username'],
                    'password' => $config['mail']['password'],
                ],
            ]);
        }

        // Setup SMTP transport
        $transport = new SmtpTransport();
        $options = new SmtpOptions($options);

        $transport->setOptions($options);

        return $transport;

    }
}
