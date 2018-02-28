<?php

namespace ZfbUser\Service\Exception;

/**
 * Class UserExistsException
 *
 * @package ZfbUser\Service\Exception
 */
class UserExistsException extends \Exception
{
    protected const ERROR_MESSAGE = 'Пользователь E-mail "%s" адресом уже зарегистрирован';

    /**
     * UserExistsException constructor.
     *
     * @param string          $identity
     * @param int             $code
     * @param \Throwable|null $previous
     */
    public function __construct(string $identity, $code = 0, \Throwable $previous = null)
    {
        $message = sprintf(self::ERROR_MESSAGE, $identity);

        parent::__construct($message, $code, $previous);
    }
}
