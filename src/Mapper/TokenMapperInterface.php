<?php

namespace ZfbUser\Mapper;

use ZfbUser\Entity\TokenInterface;

/**
 * Interface TokenMapperInterface
 *
 * @package ZfbUser\Mapper
 */
interface TokenMapperInterface extends MapperInterface
{
    /**
     * @param TokenInterface $token
     *
     * @return TokenInterface
     */
    public function insert(TokenInterface $token): TokenInterface;

    /**
     * @param TokenInterface $token
     *
     * @return TokenInterface
     */
    public function update(TokenInterface $token): TokenInterface;
}
