<?php

namespace ZfbUser\Options;

/**
 * Class RegistrationFormOptions
 *
 * @package ZfbUser\Options
 */
class RegistrationFormOptions extends AuthenticationFormOptions implements RegistrationFormOptionsInterface
{
    /**
     * @var string
     */
    protected $formName = 'registrationForm';

    /**
     * @var string
     */
    protected $credentialVerifyFieldLabel = 'Password verify';

    /**
     * @var string
     */
    protected $credentialVerifyFieldName = 'password_verify';

    /**
     * @return string
     */
    public function getCredentialVerifyFieldLabel(): string
    {
        return $this->credentialVerifyFieldLabel;
    }

    /**
     * @param string $credentialVerifyFieldLabel
     */
    public function setCredentialVerifyFieldLabel(string $credentialVerifyFieldLabel): void
    {
        $this->credentialVerifyFieldLabel = $credentialVerifyFieldLabel;
    }

    /**
     * @return string
     */
    public function getCredentialVerifyFieldName(): string
    {
        return $this->credentialVerifyFieldName;
    }

    /**
     * @param string $credentialVerifyFieldName
     */
    public function setCredentialVerifyFieldName(string $credentialVerifyFieldName): void
    {
        $this->credentialVerifyFieldName = $credentialVerifyFieldName;
    }
}
