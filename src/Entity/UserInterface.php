<?php

namespace ZfbUser\Entity;

use Zend\Stdlib\ArraySerializableInterface;

/**
 * Interface UserInterface
 *
 * @package ZfbUser\Entity
 */
interface UserInterface extends ArraySerializableInterface, \JsonSerializable
{
    /**
     * @return int
     */
    public function getId(): int;

    /**
     * @param int $id
     *
     * @return UserInterface
     */
    public function setId(int $id): UserInterface;

    /**
     * @return string
     */
    public function getIdentity(): string;

    /**
     * @param string $identity
     *
     * @return UserInterface
     */
    public function setIdentity(string $identity): UserInterface;

    /**
     * @return string
     */
    public function getCredential(): string;

    /**
     * @param string $credential
     *
     * @return UserInterface
     */
    public function setCredential(string $credential): UserInterface;

    /**
     * @return string
     */
    public function getDisplayName(): string;

    /**
     * @return bool
     */
    public function isIdentityConfirmed(): bool;

    /**
     * @param bool $confirmed
     *
     * @return UserInterface
     */
    public function setIdentityConfirmed(bool $confirmed): UserInterface;
}
