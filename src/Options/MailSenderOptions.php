<?php

namespace ZfbUser\Options;

use Zend\Stdlib\AbstractOptions;

/**
 * Class MailSenderOptions
 *
 * @package ZfbUser\Options
 */
class MailSenderOptions extends AbstractOptions implements MailSenderOptionsInterface
{
    /**
     * @var string
     */
    protected $fromEmail;

    /**
     * @var string
     */
    protected $fromName;

    /**
     * @var string
     */
    protected $templatePath;

    /**
     * @var string
     */
    protected $transportFactory = 'zfbuser_mail_sender_file_transport';

    /**
     * @return string
     */
    public function getFromEmail(): string
    {
        return $this->fromEmail;
    }

    /**
     * @param string $fromEmail
     *
     * @return MailSenderOptions
     */
    public function setFromEmail(string $fromEmail): MailSenderOptions
    {
        $this->fromEmail = $fromEmail;

        return $this;
    }

    /**
     * @return string
     */
    public function getFromName(): string
    {
        return $this->fromName;
    }

    /**
     * @param string $fromName
     *
     * @return MailSenderOptions
     */
    public function setFromName(string $fromName): MailSenderOptions
    {
        $this->fromName = $fromName;

        return $this;
    }

    /**
     * @return string
     */
    public function getTemplatePath(): string
    {
        return $this->templatePath;
    }

    /**
     * @param string $templatePath
     *
     * @return MailSenderOptions
     */
    public function setTemplatePath(string $templatePath): MailSenderOptions
    {
        $this->templatePath = $templatePath;

        return $this;
    }

    /**
     * @return string
     */
    public function getTransportFactory(): string
    {
        return $this->transportFactory;
    }

    /**
     * @param string $transportFactory
     *
     * @return MailSenderOptions
     */
    public function setTransportFactory(string $transportFactory): MailSenderOptions
    {
        $this->transportFactory = $transportFactory;

        return $this;
    }
}
