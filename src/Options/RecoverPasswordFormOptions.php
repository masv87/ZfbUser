<?php

namespace ZfbUser\Options;

/**
 * Class RecoverPasswordFormOptions
 *
 * @package ZfbUser\Options
 */
class RecoverPasswordFormOptions extends FormOptions implements RecoverPasswordFormOptionsInterface
{
    /**
     * @var string
     */
    protected $formName = 'recoverPasswordForm';

    /**
     * @var string
     */
    protected $identityFieldLabel = 'E-mail';

    /**
     * @var string
     */
    protected $identityFieldName = 'email';

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
     * @return \ZfbUser\Options\RecoverPasswordFormOptions
     */
    public function setIdentityFieldLabel(string $identityFieldLabel): RecoverPasswordFormOptions
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
     * @return \ZfbUser\Options\RecoverPasswordFormOptions
     */
    public function setIdentityFieldName(string $identityFieldName): RecoverPasswordFormOptions
    {
        $this->identityFieldName = $identityFieldName;

        return $this;
    }
}
