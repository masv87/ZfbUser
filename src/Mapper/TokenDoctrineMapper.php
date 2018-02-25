<?php

namespace ZfbUser\Mapper;

use ZfbUser\Entity\TokenInterface;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class TokenDoctrineMapper
 *
 * @package ZfbUser\Mapper
 */
class TokenDoctrineMapper implements TokenMapperInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * TokenDoctrineMapper constructor.
     *
     * @param \Doctrine\ORM\EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param TokenInterface $token
     *
     * @return TokenInterface
     */
    public function insert(TokenInterface $token): TokenInterface
    {
        return $this->saveToken($token);
    }

    /**
     * @param TokenInterface $token
     *
     * @return TokenInterface
     */
    public function update(TokenInterface $token): TokenInterface
    {
        return $this->saveToken($token);
    }

    /**
     * @param \ZfbUser\Entity\TokenInterface $token
     *
     * @return \ZfbUser\Entity\TokenInterface
     */
    private function saveToken(TokenInterface $token): TokenInterface
    {
        $this->entityManager->persist($token);
        $this->entityManager->flush();

        return $token;
    }
}
