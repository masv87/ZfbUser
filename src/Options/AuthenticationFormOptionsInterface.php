<?php

namespace ZfbUser\Options;

/**
 * Interface AuthenticationFormOptionsInterface
 *
 * @package ZfbUser\Options
 */
interface AuthenticationFormOptionsInterface extends FormOptionsInterface
{
    /**
     * @return string
     */
    public function getIdentityFieldLabel(): string;

    /**
     * @return string
     */
    public function getCredentialFieldLabel(): string;

    /**
     * @return string
     */
    public function getIdentityFieldName(): string;

    /**
     * @return string
     */
    public function getCredentialFieldName(): string;
}
