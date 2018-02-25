<?php

namespace ZfbUser\Repository;

use ZfbUser\Entity\TokenInterface;
use ZfbUser\Entity\UserInterface;

/**
 * Interface TokenRepositoryInterface
 *
 * @package ZfbUser\Repository
 */
interface TokenRepositoryInterface
{
    /**
     * @param \ZfbUser\Entity\UserInterface $user
     * @param string                        $value
     * @param string                        $type
     *
     * @return null|\ZfbUser\Entity\TokenInterface
     */
    public function getToken(UserInterface $user, string $value, string $type): ?TokenInterface;

    /**
     * @param null|\ZfbUser\Entity\UserInterface $user
     * @param null|string                        $type
     *
     * @return array
     */
    public function getActualTokens(?UserInterface $user, ?string $type): array;
}
