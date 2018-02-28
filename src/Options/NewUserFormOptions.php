<?php

namespace ZfbUser\Options;

/**
 * Class NewUserFormOptions
 *
 * @package ZfbUser\Options
 */
class NewUserFormOptions extends FormOptions implements NewUserFormOptionsInterface
{
    /**
     * @var string
     */
    protected $formName = 'newUserForm';

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
     * @return \ZfbUser\Options\NewUserFormOptions
     */
    public function setIdentityFieldLabel(string $identityFieldLabel): NewUserFormOptions
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
     * @return \ZfbUser\Options\NewUserFormOptions
     */
    public function setIdentityFieldName(string $identityFieldName): NewUserFormOptions
    {
        $this->identityFieldName = $identityFieldName;

        return $this;
    }
}
