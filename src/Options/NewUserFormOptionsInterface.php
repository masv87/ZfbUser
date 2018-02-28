<?php

namespace ZfbUser\Options;

/**
 * Interface NewUserFormOptionsInterface
 *
 * @package ZfbUser\Options
 */
interface NewUserFormOptionsInterface extends FormOptionsInterface
{
    /**
     * @return string
     */
    public function getIdentityFieldLabel(): string;

    /**
     * @return string
     */
    public function getIdentityFieldName(): string;
}
