<?php

namespace ZfbUser\Options;

/**
 * Interface ReCaptchaOptionsInterface
 *
 * @package ZfbUser\Options
 */
interface ReCaptchaOptionsInterface extends OptionsInterface
{
    /**
     * @return string
     */
    public function getSiteKey(): string;

    /**
     * @return string
     */
    public function getSecretKey(): string;

    /**
     * @return string
     */
    public function getTheme(): string;

    /**
     * @return string
     */
    public function getSize(): string;

    /**
     * @return string
     */
    public function getHl(): string;
}
