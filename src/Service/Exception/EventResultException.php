<?php

namespace ZfbUser\Service\Exception;

use ZfbUser\EventProvider\EventResultInterface;

/**
 * Class EventResultException
 *
 * @package ZfbUser\Service\Exception
 */
class EventResultException extends \Exception
{
    protected const ERROR_MESSAGE = 'Event listener result must implement "' . EventResultInterface::class . '"';

    /**
     * EventResultException constructor.
     *
     * @param string          $message
     * @param int             $code
     * @param \Throwable|null $previous
     */
    public function __construct($message = "", $code = 0, \Throwable $previous = null)
    {
        if (empty($message)) {
            $message = self::ERROR_MESSAGE;
        }

        parent::__construct($message, $code, $previous);
    }
}
