<?php

namespace ZfbUser\Options;

/**
 * Class AuthenticationFormOptions
 *
 * @package ZfbUser\Options
 */
class AuthenticationFormOptions extends FormOptions implements AuthenticationFormOptionsInterface
{
    /**
     * @var string
     */
    protected $formName = 'authenticationForm';

    /**
     * @var string
     */
    protected $identityFieldLabel = 'E-mail';

    /**
     * @var string
     */
    protected $identityFieldName = 'email';

    /**
     * @var string
     */
    protected $credentialFieldLabel = 'Password';

    /**
     * @var string
     */
    protected $credentialFieldName = 'password';

    /**
     * @return string
     */
    public function getIdentityFieldLabel(): string
    {
        return $this->identityFieldLabel;
    }

    /**
     * @param string $identityFieldLabel
     *
     * @return AuthenticationFormOptions
     */
    public function setIdentityFieldLabel(string $identityFieldLabel): AuthenticationFormOptions
    {
        $this->identityFieldLabel = $identityFieldLabel;

        return $this;
    }

    /**
     * @return string
     */
    public function getIdentityFieldName(): string
    {
        return $this->identityFieldName;
    }

    /**
     * @param string $identityFieldName
     *
     * @return AuthenticationFormOptions
     */
    public function setIdentityFieldName(string $identityFieldName): AuthenticationFormOptions
    {
        $this->identityFieldName = $identityFieldName;

        return $this;
    }

    /**
     * @return string
     */
    public function getCredentialFieldLabel(): string
    {
        return $this->credentialFieldLabel;
    }

    /**
     * @param string $credentialFieldLabel
     *
     * @return AuthenticationFormOptions
     */
    public function setCredentialFieldLabel(string $credentialFieldLabel): AuthenticationFormOptions
    {
        $this->credentialFieldLabel = $credentialFieldLabel;

        return $this;
    }

    /**
     * @return string
     */
    public function getCredentialFieldName(): string
    {
        return $this->credentialFieldName;
    }

    /**
     * @param string $credentialFieldName
     *
     * @return AuthenticationFormOptions
     */
    public function setCredentialFieldName(string $credentialFieldName): AuthenticationFormOptions
    {
        $this->credentialFieldName = $credentialFieldName;

        return $this;
    }
}
