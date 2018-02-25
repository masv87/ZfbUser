<?php

namespace ZfbUser\Options;

/**
 * Interface MailSenderOptionsInterface
 *
 * @package ZfbUser\Options
 */
interface MailSenderOptionsInterface extends OptionsInterface
{
    /**
     * @return string
     */
    public function getFromEmail(): string;

    /**
     * @return string
     */
    public function getFromName(): string;

    /**
     * @return string
     */
    public function getTemplatePath(): string;
}
