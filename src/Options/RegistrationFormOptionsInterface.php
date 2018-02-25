<?php

namespace ZfbUser\Options;

/**
 * Interface RegistrationFormOptionsInterface
 *
 * @package ZfbUser\Options
 */
interface RegistrationFormOptionsInterface extends AuthenticationFormOptionsInterface
{
    /**
     * @return string
     */
    public function getCredentialVerifyFieldLabel(): string;

    /**
     * @return string
     */
    public function getCredentialVerifyFieldName(): string;
}
