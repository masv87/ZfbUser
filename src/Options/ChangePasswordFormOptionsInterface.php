<?php

namespace ZfbUser\Options;

/**
 * Interface ChangePasswordFormOptionsInterface
 *
 * @package ZfbUser\Options
 */
interface ChangePasswordFormOptionsInterface extends FormOptionsInterface
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
