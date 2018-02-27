<?php

namespace ZfbUser\Service\Exception;

/**
 * Class MailTemplateNotFoundException
 *
 * @package ZfbUser\Service\Exception
 */
class MailTemplateNotFoundException extends \Exception
{
    protected const ERROR_MESSAGE = 'Mail template "%s" not found';

    /**
     * MailTemplateNotFoundException constructor.
     *
     * @param string          $file
     * @param int             $code
     * @param \Throwable|null $previous
     */
    public function __construct(string $file, $code = 0, \Throwable $previous = null)
    {
        $message = sprintf(static::ERROR_MESSAGE, $file);

        parent::__construct($message, $code, $previous);
    }
}
