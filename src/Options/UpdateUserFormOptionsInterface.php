<?php

namespace ZfbUser\Options;

/**
 * Interface UpdateUserFormOptionsInterface
 *
 * @package ZfbUser\Options
 */
interface UpdateUserFormOptionsInterface extends FormOptionsInterface
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
