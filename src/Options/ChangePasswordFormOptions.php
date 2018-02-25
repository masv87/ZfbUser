<?php

namespace ZfbUser\Options;

/**
 * Class ChangePasswordFormOptions
 *
 * @package ZfbUser\Options
 */
class ChangePasswordFormOptions extends FormOptions implements ChangePasswordFormOptionsInterface
{
    /**
     * @var string
     */
    protected $formName = 'changePasswordForm';

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
    protected $credentialVerifyFieldLabel = 'Password verify';

    /**
     * @var string
     */
    protected $credentialVerifyFieldName = 'password_verify';

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
     * @return ChangePasswordFormOptions
     */
    public function setCredentialFieldLabel(string $credentialFieldLabel): ChangePasswordFormOptions
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
     * @return ChangePasswordFormOptions
     */
    public function setCredentialFieldName(string $credentialFieldName): ChangePasswordFormOptions
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
     * @return ChangePasswordFormOptions
     */
    public function setCredentialVerifyFieldLabel(string $credentialVerifyFieldLabel): ChangePasswordFormOptions
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
     * @return ChangePasswordFormOptions
     */
    public function setCredentialVerifyFieldName(string $credentialVerifyFieldName): ChangePasswordFormOptions
    {
        $this->credentialVerifyFieldName = $credentialVerifyFieldName;

        return $this;
    }
}
