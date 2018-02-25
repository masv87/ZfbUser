<?php

namespace ZfbUser\Mapper;

use ZfbUser\Entity\UserInterface;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class UserDoctrineMapper
 *
 * @package ZfbUser\Mapper
 */
class UserDoctrineMapper implements UserMapperInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * UserDoctrineMapper constructor.
     *
     * @param \Doctrine\ORM\EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

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
