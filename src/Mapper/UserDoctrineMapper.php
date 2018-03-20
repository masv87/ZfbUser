<?php

namespace ZfbUser\Mapper;

use ZfbUser\Entity\UserInterface;

/**
 * Class UserDoctrineMapper
 *
 * @package ZfbUser\Mapper
 */
class UserDoctrineMapper extends DoctrineMapper implements UserMapperInterface
{
    /**
     * @param UserInterface $user
     *
     * @return UserInterface
     */
    public function insert(UserInterface $user): UserInterface
    {
        return $this->saveUser($user);
    }

    /**
     * @param UserInterface $user
     *
     * @return UserInterface
     */
    public function update(UserInterface $user): UserInterface
    {
        return $this->saveUser($user);
    }

    /**
     * @param \ZfbUser\Entity\UserInterface $user
     */
    public function delete(UserInterface $user)
    {
        $this->entityManager->remove($user);
        $this->entityManager->flush();
    }

    /**
     * @param \ZfbUser\Entity\UserInterface $user
     *
     * @return \ZfbUser\Entity\UserInterface
     */
    private function saveUser(UserInterface $user): UserInterface
    {
        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $user;
    }
}
