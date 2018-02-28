<?php

namespace ZfbUser\Options;

/**
 * Class ResetPasswordFormOptions
 *
 * @package ZfbUser\Options
 */
class ResetPasswordFormOptions extends FormOptions implements ResetPasswordFormOptionsInterface
{
    /**
     * @var string
     */
    protected $formName = 'resetPasswordForm';

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
     * @return ResetPasswordFormOptions
     */
    public function setCredentialFieldLabel(string $credentialFieldLabel): ResetPasswordFormOptions
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
     * @return ResetPasswordFormOptions
     */
    public function setCredentialFieldName(string $credentialFieldName): ResetPasswordFormOptions
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
     * @return ResetPasswordFormOptions
     */
    public function setCredentialVerifyFieldLabel(string $credentialVerifyFieldLabel): ResetPasswordFormOptions
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
     * @return ResetPasswordFormOptions
     */
    public function setCredentialVerifyFieldName(string $credentialVerifyFieldName): ResetPasswordFormOptions
    {
        $this->credentialVerifyFieldName = $credentialVerifyFieldName;

        return $this;
    }
}
