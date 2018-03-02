<?php

namespace ZfbUser\Options;

/**
 * Class SetPasswordFormOptions
 *
 * @package ZfbUser\Options
 */
class SetPasswordFormOptions extends FormOptions implements SetPasswordFormOptionsInterface
{
    /**
     * @var string
     */
    protected $formName = 'setPasswordForm';

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
     * @var string
     */
    protected $credentialVerifyFieldLabel = 'Password Verify';

    /**
     * @var string
     */
    protected $credentialVerifyFieldName = 'password_verify';

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
     * @return SetPasswordFormOptions
     */
    public function setIdentityFieldLabel(string $identityFieldLabel): SetPasswordFormOptions
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
     * @return SetPasswordFormOptions
     */
    public function setIdentityFieldName(string $identityFieldName): SetPasswordFormOptions
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
     * @return SetPasswordFormOptions
     */
    public function setCredentialFieldLabel(string $credentialFieldLabel): SetPasswordFormOptions
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
     * @return SetPasswordFormOptions
     */
    public function setCredentialFieldName(string $credentialFieldName): SetPasswordFormOptions
    {
        $this->credentialFieldName = $credentialFieldName;

        return $this;
    }

    /**
     * @return string
     */
    public function getCredentialVerifyFieldLabel(): string
    {
        return $this->credentialVerifyFieldLabel;
    }

    /**
     * @param string $credentialVerifyFieldLabel
     *
     * @return SetPasswordFormOptions
     */
    public function setCredentialVerifyFieldLabel(string $credentialVerifyFieldLabel): SetPasswordFormOptions
    {
        $this->credentialVerifyFieldLabel = $credentialVerifyFieldLabel;

        return $this;
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
     *
     * @return SetPasswordFormOptions
     */
    public function setCredentialVerifyFieldName(string $credentialVerifyFieldName): SetPasswordFormOptions
    {
        $this->credentialVerifyFieldName = $credentialVerifyFieldName;

        return $this;
    }
}
