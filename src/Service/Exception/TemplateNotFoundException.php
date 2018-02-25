<?php

namespace ZfbUser\Service\Exception;

/**
 * Class TemplateNotFoundException
 *
 * @package ZfbUser\Service\Exception
 */
class TemplateNotFoundException extends \Exception
{
    protected const ERROR_MESSAGE = 'Template not found';

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
