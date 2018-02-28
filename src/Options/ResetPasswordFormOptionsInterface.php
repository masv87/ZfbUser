<?php

namespace ZfbUser\Options;

/**
 * Interface ResetPasswordFormOptionsInterface
 *
 * @package ZfbUser\Options
 */
interface ResetPasswordFormOptionsInterface extends FormOptionsInterface
{
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
