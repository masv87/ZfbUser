<?php

namespace ZfbUser\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\ClassMetadata;
use ZfbUser\Entity\UserInterface;
use ZfbUser\Options\ModuleOptionsInterface;

/**
 * Class UserRepository
 *
 * @package ZfbUser\Repository
 */
class UserRepository extends EntityRepository implements UserRepositoryInterface
{
    /**
     * @var ModuleOptionsInterface
     */
    private $moduleOptions;

    /**
     * UserRepository constructor.
     *
     * @param \Doctrine\ORM\EntityManager|\Doctrine\ORM\EntityManagerInterface $em
     * @param \Doctrine\ORM\Mapping\ClassMetadata                              $class
     * @param \ZfbUser\Options\ModuleOptionsInterface                          $moduleOptions
     */
    public function __construct($em, ClassMetadata $class, ModuleOptionsInterface $moduleOptions)
    {
        parent::__construct($em, $class);

        $this->moduleOptions = $moduleOptions;
    }

    /**
     * @param string $identity
     *
     * @return null|\ZfbUser\Entity\UserInterface
     */
    public function getUserByIdentity(string $identity): ?UserInterface
    {
        $identityFieldName = $this->moduleOptions->getAuthenticationFormOptions()->getIdentityFieldName();

        /** @var UserInterface|null $user */
        $user = $this->findOneBy([$identityFieldName => $identity]);

        return $user;
    }

    /**
     * @param int $id
     *
     * @return null|\ZfbUser\Entity\UserInterface
     */
    public function getUserById(int $id): ?UserInterface
    {
        $idFieldName = 'id';

        /** @var UserInterface|null $user */
        $user = $this->findOneBy([$idFieldName => $id]);

        return $user;
    }
}
