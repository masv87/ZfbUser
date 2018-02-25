<?php

namespace ZfbUser\Entity;

/**
 * Interface TokenInterface
 *
 * @package ZfbUser\Entity
 */
interface TokenInterface
{
    /**
     * @return int
     */
    public function getId(): int;

    /**
     * @param int $id
     *
     * @return \ZfbUser\Entity\TokenInterface
     */
    public function setId(int $id): TokenInterface;

    /**
     * @return UserInterface
     */
    public function getUser(): UserInterface;

    /**
     * @param UserInterface $user
     *
     * @return \ZfbUser\Entity\TokenInterface
     */
    public function setUser(UserInterface $user): TokenInterface;

    /**
     * @return string
     */
    public function getType(): string;

    /**
     * @param string $type
     *
     * @return TokenInterface
     */
    public function setType(string $type): TokenInterface;

    /**
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime;

    /**
     * @param \DateTime $createdAt
     *
     * @return \ZfbUser\Entity\TokenInterface
     */
    public function setCreatedAt(\DateTime $createdAt): TokenInterface;

    /**
     * @return \DateTime
     */
    public function getExpiredAt(): \DateTime;

    /**
     * @param \DateTime $expiredAt
     *
     * @return \ZfbUser\Entity\TokenInterface
     */
    public function setExpiredAt(\DateTime $expiredAt): TokenInterface;

    /**
     * @return bool
     */
    public function isRevoked(): bool;

    /**
     * @param bool $revoked
     *
     * @return \ZfbUser\Entity\TokenInterface
     */
    public function setRevoked(bool $revoked): TokenInterface;

    /**
     * @return string
     */
    public function getValue(): string;

    /**
     * @param string $value
     *
     * @return \ZfbUser\Entity\TokenInterface
     */
    public function setValue(string $value): TokenInterface;
}
