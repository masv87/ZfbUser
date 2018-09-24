<?php

namespace ZfbUser\Service;

use Zend\Mail\Message;
use Zend\Mail\Transport\TransportInterface;
use Zend\Mime\Message as MimeMessage;
use Zend\Mime\Mime;
use Zend\Mime\Part as MimePart;
use ZfbUser\Entity\UserInterface;
use ZfbUser\Options\MailSenderOptionsInterface;

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
        $this->sendTo($user->getIdentity(), $user->getDisplayName(), $template, $data);
    }

    /**
     * @param string $email
     * @param string $displayName
     * @param string $template
     * @param array $data
     */
    public function sendTo(string $email, string $displayName, string $template, array $data): void
    {
        $mail = new Message();
        $mail->setFrom($this->options->getFromEmail(), $this->options->getFromName());
        $mail->addTo($email, $displayName);
        $subject = $this->getSubject($template);
        $mail->setEncoding('UTF-8');

        foreach ($data as $k => $v) {
            $template = str_replace('%' . $k . '%', $v, $template);
            $subject = str_replace('%' . $k . '%', $v, $subject);
        }
        $mail->setSubject($subject);
        $html = new MimePart($template);
        $html->type = Mime::TYPE_HTML;
        $html->charset = 'utf-8';
        //$html->encoding = Mime::ENCODING_QUOTEDPRINTABLE;

        $body = new MimeMessage();
        $body->setParts([$html]);

        $mail->setBody($body);

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
