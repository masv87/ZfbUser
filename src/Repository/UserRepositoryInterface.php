<?php

namespace ZfbUser\Repository;

use ZfbUser\Entity\UserInterface;

/**
 * Interface UserRepositoryInterface
 *
 * @package ZfbUser\Repository
 */
interface UserRepositoryInterface
{
    /**
     * @param string $identity
     *
     * @return null|UserInterface
     */
    public function getUserByIdentity(string $identity): ?UserInterface;

    /**
     * @param int $id
     *
     * @return null|UserInterface
     */
    public function getUserById(int $id): ?UserInterface;
}
