<?php

namespace ZfbUser\Service\Exception;

/**
 * Class UserExistsException
 *
 * @package ZfbUser\Service\Exception
 */
class UserExistsException extends \Exception
{
    protected const ERROR_MESSAGE = 'Пользователь с таким E-mail адресом уже зарегистрирован';

    /**
     * UserExistsException constructor.
     *
     * @param string          $message
     * @param int             $code
     * @param \Throwable|null $previous
     */
    public function __construct($message = "", $code = 0, \Throwable $previous = null)
    {
        if (empty($message)) {
            $message = static::ERROR_MESSAGE;
        }
        parent::__construct($message, $code, $previous);
    }
}
