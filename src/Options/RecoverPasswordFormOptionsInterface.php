<?php

namespace ZfbUser\Options;

/**
 * Interface RecoverPasswordFormOptionsInterface
 *
 * @package ZfbUser\Options
 */
interface RecoverPasswordFormOptionsInterface extends FormOptionsInterface
{
    /**
     * @return string
     */
    public function getIdentityFieldLabel(): string;

    /**
     * @return string
     */
    public function getIdentityFieldName(): string;
}
