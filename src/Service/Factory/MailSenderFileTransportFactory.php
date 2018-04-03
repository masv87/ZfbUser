<?php

namespace ZfbUser\Service\Factory;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;
use Zend\Mail\Transport\File as FileTransport;
use Zend\Mail\Transport\FileOptions;

/**
 * Class MailSenderFileTransportFactory
 *
 * @package ZfbUser\Service\Factory
 */
class MailSenderFileTransportFactory implements FactoryInterface
{
    /**
     * @param \Interop\Container\ContainerInterface $container
     * @param string                                $requestedName
     * @param array|null                            $options
     *
     * @return \Zend\Mail\Transport\File
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        // Setup File transport
        $transport = new FileTransport();
        $options = new FileOptions([
            'path'     => 'data/mail/',
            'callback' => function (FileTransport $transport) {
                return sprintf(
                    'msg_%s.txt',
                    date('Y_m_d_H_i_s')
                );
            },
        ]);
        $transport->setOptions($options);

        return $transport;
    }
}
