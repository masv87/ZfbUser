<?php

namespace ZfbUser;

use Zend\Authentication\Result;
use ZfbUser\Entity\UserInterface;

/**
 * Class AuthenticationResult
 *
 * @package ZfbUser
 */
class AuthenticationResult extends Result
{
    /**
     * Учетная запись не подтверждена
     */
    const FAILURE_IDENTITY_NOT_CONFIRMED = -90;

    /**
     * Не удалось подтвердить учетную запись
     */
    const FAILURE_IDENTITY_CONFIRMATION = -91;

    /**
     * Не удалось сбросить пароль
     */
    const FAILURE_RECOVER_PASSWORD = -92;

    /**
     * Invalid token
     */
    const FAILURE_TOKEN_INVALID = -93;

    /**
     * Change password error
     */
    const FAILURE_CHANGE_PASSWORD = -94;

    /**
     * Invalid old password
     */
    const FAILURE_OLD_PASSWORD_INVALID = -95;

    /**
     * Fail set password
     */
    const FAILURE_SET_PASSWORD = -96;

    const MESSAGE_TEMPLATES = [
        self::FAILURE                        => "Authentication failed. Please try again.",
        self::FAILURE_IDENTITY_NOT_FOUND     => "Authentication failed. Please try again.",
        self::FAILURE_IDENTITY_AMBIGUOUS     => "Authentication failed. Please try again.",
        self::FAILURE_CREDENTIAL_INVALID     => "Authentication failed. Please try again.",
        self::FAILURE_UNCATEGORIZED          => "Authentication failed. Please try again.",
        self::FAILURE_IDENTITY_NOT_CONFIRMED => "Identity is not confirmed",
        self::FAILURE_IDENTITY_CONFIRMATION  => "Confirmation failed. Please try again.",
        self::FAILURE_RECOVER_PASSWORD       => "Password reset failed. Please try again.",
        self::FAILURE_TOKEN_INVALID          => "Token invalid. Please try again.",
        self::FAILURE_CHANGE_PASSWORD        => "Change password error. Please try again.",
        self::FAILURE_OLD_PASSWORD_INVALID   => "Old password invalid. Please try again.",
        self::FAILURE_SET_PASSWORD           => "Set password error. Please try again.",

        self::SUCCESS => "Authentication success",
    ];

    /**
     * @var UserInterface
     */
    protected $identity;

    /**
     * AuthenticationResult constructor.
     *
     * @param string                             $code
     * @param null|\ZfbUser\Entity\UserInterface $identity
     * @param array                              $messages
     */
    public function __construct(string $code, ?UserInterface $identity, array $messages = [])
    {
        parent::__construct($code, $identity, $messages);
    }

    /**
     * @return null|\ZfbUser\Entity\UserInterface
     */
    public function getIdentity(): ?UserInterface
    {
        return $this->identity;
    }
}
