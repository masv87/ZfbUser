<?php

namespace ZfbUser\Entity;

/**
 * Interface LogInterface
 *
 * @package ZfbUser\Entity
 */
interface LogInterface
{
    /**
     * @return int
     */
    public function getId(): int;

    /**
     * @param int $id
     *
     * @return LogInterface
     */
    public function setId(int $id): LogInterface;

    /**
     * @return null|\ZfbUser\Entity\UserInterface
     */
    public function getUser(): ?UserInterface;

    /**
     * @param null|\ZfbUser\Entity\UserInterface $user
     *
     * @return LogInterface
     */
    public function setUser(?UserInterface $user): LogInterface;

    /**
     * @return \DateTime
     */
    public function getDatetime(): \DateTime;

    /**
     * @param \DateTime $datetime
     *
     * @return LogInterface
     */
    public function setDatetime(\DateTime $datetime): LogInterface;

    /**
     * @return string
     */
    public function getType(): string;

    /**
     * @param string $type
     *
     * @return LogInterface
     */
    public function setType(string $type): LogInterface;

    /**
     * @return bool|null
     */
    public function isSuccess(): ?bool;

    /**
     * @param bool|null $success
     *
     * @return \ZfbUser\Entity\LogInterface
     */
    public function setSuccess(?bool $success): LogInterface;

    /**
     * @return null|string
     */
    public function getMessage(): ?string;

    /**
     * @param null|string $message
     *
     * @return LogInterface
     */
    public function setMessage(?string $message): LogInterface;
}
