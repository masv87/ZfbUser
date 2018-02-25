<?php

namespace ZfbUser\Options;

/**
 * Interface FormOptionsInterface
 *
 * @package ZfbUser\Options
 */
interface FormOptionsInterface extends OptionsInterface
{
    /**
     * @return string
     */
    public function getFormName(): string;

    /**
     * @return string
     */
    public function getSubmitButtonText(): string;

    /**
     * @return int
     */
    public function getCsrfTimeout(): int;

    /**
     * @return bool
     */
    public function isEnabledRecaptcha(): bool;
}
