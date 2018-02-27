<?php

namespace ZfbUser\Mapper;

use ZfbUser\Entity\UserInterface;

/**
 * Interface UserMapperInterface
 *
 * @package ZfbUser\Mapper
 */
interface UserMapperInterface extends MapperInterface
{
    /**
     * @param UserInterface $user
     *
     * @return UserInterface
     */
    public function insert(UserInterface $user): UserInterface;

    /**
     * @param UserInterface $user
     *
     * @return UserInterface
     */
    public function update(UserInterface $user): UserInterface;
}
