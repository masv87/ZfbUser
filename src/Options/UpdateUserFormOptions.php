<?php

namespace ZfbUser\Options;

/**
 * Class UpdateUserFormOptions
 *
 * @package ZfbUser\Options
 */
class UpdateUserFormOptions extends FormOptions implements UpdateUserFormOptionsInterface
{
    /**
     * @var string
     */
    protected $formName = 'updateUserForm';

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
     * @return \ZfbUser\Options\UpdateUserFormOptions
     */
    public function setIdentityFieldLabel(string $identityFieldLabel): UpdateUserFormOptions
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
     * @return \ZfbUser\Options\UpdateUserFormOptions
     */
    public function setIdentityFieldName(string $identityFieldName): UpdateUserFormOptions
    {
        $this->identityFieldName = $identityFieldName;

        return $this;
    }
}
