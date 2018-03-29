<?php

namespace ZfbUser\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="ZfbUser\Repository\LogRepository")
 * @ORM\Table(name="zfb_log")
 */
class Log implements LogInterface
{
    const TYPE_AUTHENTICATE = 'authenticate';
    const TYPE_LOGOUT = 'logout';

    /**
     * Идентификатор записи
     *
     * @var int
     *
     * @ORM\Id @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @var UserInterface|null
     *
     * @ORM\ManyToOne(targetEntity="ZfbUser\Entity\User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=true, onDelete="CASCADE")
     */
    protected $user;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datetime", type="datetime", nullable=false)
     */
    protected $datetime;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", nullable=false)
     */
    protected $type;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="success", type="boolean", nullable=true)
     */
    protected $success;

    /**
     * @var string|null
     *
     * @ORM\Column(name="message", type="string", nullable=true)
     */
    protected $message;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     *
     * @return LogInterface
     */
    public function setId(int $id): LogInterface
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return null|\ZfbUser\Entity\UserInterface
     */
    public function getUser(): ?UserInterface
    {
        return $this->user;
    }

    /**
     * @param null|\ZfbUser\Entity\UserInterface $user
     *
     * @return LogInterface
     */
    public function setUser(?UserInterface $user): LogInterface
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDatetime(): \DateTime
    {
        return $this->datetime;
    }

    /**
     * @param \DateTime $datetime
     *
     * @return LogInterface
     */
    public function setDatetime(\DateTime $datetime): LogInterface
    {
        $this->datetime = $datetime;

        return $this;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     *
     * @return LogInterface
     */
    public function setType(string $type): LogInterface
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function isSuccess(): ?bool
    {
        return $this->success;
    }

    /**
     * @param bool|null $success
     *
     * @return \ZfbUser\Entity\LogInterface
     */
    public function setSuccess(?bool $success): LogInterface
    {
        $this->success = $success;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getMessage(): ?string
    {
        return $this->message;
    }

    /**
     * @param null|string $message
     *
     * @return LogInterface
     */
    public function setMessage(?string $message): LogInterface
    {
        $this->message = $message;

        return $this;
    }
}
