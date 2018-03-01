<?php

namespace ZfbUser\EventProvider;

/**
 * Interface EventResultInterface
 *
 * @package ZfbUser\EventProvider
 */
interface EventResultInterface
{
    /**
     * @return bool
     */
    public function hasError(): bool;

    /**
     * @return null|string
     */
    public function getErrorMessage(): ?string;
}
