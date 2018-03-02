<?php

namespace ZfbUser\Options;

/**
 * Interface SetPasswordFormOptionsInterface
 *
 * @package ZfbUser\Options
 */
interface SetPasswordFormOptionsInterface extends FormOptionsInterface
{
    /**
     * @return string
     */
    public function getIdentityFieldLabel(): string;

    /**
     * @return string
     */
    public function getIdentityFieldName(): string;

    /**
     * @return string
     */
    public function getCredentialFieldLabel(): string;

    /**
     * @return string
     */
    public function getCredentialFieldName(): string;

    /**
     * @return string
     */
    public function getCredentialVerifyFieldLabel(): string;

    /**
     * @return string
     */
    public function getCredentialVerifyFieldName(): string;
}
