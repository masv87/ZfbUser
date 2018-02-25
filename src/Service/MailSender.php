<?php

namespace ZfbUser\Service;

use Zend\Mail\Message;
use Zend\Mail\Transport\TransportInterface;
use ZfbUser\Options\MailSenderOptionsInterface;
use ZfbUser\Entity\UserInterface;

/**
 * Class MailSender
 *
 * @package ZfbUser\Service
 */
class MailSender implements MailSenderInterface
{
    /**
     * @var MailSenderOptionsInterface
     */
    private $options;

    /**
     * @var TransportInterface
     */
    private $transport;

    /**
     * MailSender constructor.
     *
     * @param \ZfbUser\Options\MailSenderOptionsInterface $options
     * @param \Zend\Mail\Transport\TransportInterface     $transport
     */
    public function __construct(MailSenderOptionsInterface $options, TransportInterface $transport)
    {
        $this->options = $options;
        $this->transport = $transport;
    }

    /**
     * @param \ZfbUser\Entity\UserInterface $user
     * @param string                        $template
     * @param array                         $data
     */
    public function send(UserInterface $user, string $template, array $data): void
    {
        $mail = new Message();
        $mail->setFrom($this->options->getFromEmail(), $this->options->getFromName());
        $mail->addTo($user->getIdentity(), $user->getDisplayName());
        $mail->setSubject($this->getSubject($template));
        $mail->setEncoding('UTF-8');

        foreach ($data as $k => $v) {
            $template = str_replace('%' . $k . '%', $v, $template);
        }

        $mail->setBody($template);

        $this->transport->send($mail);
    }

    /**
     * @param string $template
     *
     * @return string
     */
    protected function getSubject(string $template)
    {
        $subject = '';
        $dom = new \DOMDocument('1.0', 'UTF-8');
        $dom->loadHTML(mb_convert_encoding($template, 'HTML-ENTITIES', 'UTF-8'));
        $xpath = new \DOMXPath($dom);
        $query = "//title";
        $entries = $xpath->query($query);
        /** @var \DOMElement $entry */
        foreach ($entries as $entry) {
            $subject = $entry->nodeValue;
            break;
        }

        return $subject;
    }
}
