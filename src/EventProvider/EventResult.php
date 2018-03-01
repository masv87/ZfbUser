<?php

namespace ZfbUser\EventProvider;

use ZfbUser\Service\Exception\EventResultException;

/**
 * Class EventResult
 *
 * @package ZfbUser\EventProvider
 */
class EventResult implements EventResultInterface
{
    /**
     * @var bool
     */
    protected $hasError = false;

    /**
     * @var string|null
     */
    protected $errorMessage;

    /**
     * EventResult constructor.
     *
     * @param bool        $hasError
     * @param null|string $errorMessage
     *
     * @throws \ZfbUser\Service\Exception\EventResultException
     */
    public function __construct(bool $hasError, ?string $errorMessage = null)
    {
        if ($hasError === true && empty($errorMessage)) {
            throw new EventResultException('errorMessage is required');
        }
        $this->hasError = $hasError;
        $this->errorMessage = $errorMessage;
    }

    /**
     * @inheritdoc
     */
    public function hasError(): bool
    {
        return $this->hasError;
    }

    /**
     * @inheritdoc
     */
    public function getErrorMessage(): ?string
    {
        return $this->errorMessage;
    }
}
