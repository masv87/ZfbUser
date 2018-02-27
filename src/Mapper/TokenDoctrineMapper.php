<?php

namespace ZfbUser\Mapper;

use ZfbUser\Entity\TokenInterface;

/**
 * Class TokenDoctrineMapper
 *
 * @package ZfbUser\Mapper
 */
class TokenDoctrineMapper extends DoctrineMapper implements TokenMapperInterface
{
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
