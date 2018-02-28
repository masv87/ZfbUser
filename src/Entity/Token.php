<?php

namespace ZfbUser\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="ZfbUser\Repository\TokenRepository")
 * @ORM\Table(name="zfb_tokens", indexes={
 *     @ORM\Index(name="user_value_type_idx", columns={"user_id", "value", "type"}),
 *     @ORM\Index(name="revoked_expired_at_user_id_type_idx", columns={"revoked", "expired_at", "user_id", "type"})
 * })
 */
class Token implements TokenInterface
{
    /**
     * Идентификатор пользователя
     *
     * @var int
     *
     * @ORM\Id @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var UserInterface
     *
     * @ORM\ManyToOne(targetEntity="ZfbUser\Entity\User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     */
    protected $user;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", nullable=false)
     */
    protected $type;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     */
    protected $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="expired_at", type="datetime", nullable=false)
     */
    protected $expiredAt;

    /**
     * @var bool
     *
     * @ORM\Column(name="revoked", type="boolean", nullable=false)
     */
    protected $revoked = false;

    /**
     * @var string
     *
     * @ORM\Column(name="value", type="string", length=100, unique=true, nullable=true, options={"fixed": true})
     */
    protected $value;

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
     * @return TokenInterface
     */
    public function setId(int $id): TokenInterface
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return UserInterface
     */
    public function getUser(): UserInterface
    {
        return $this->user;
    }

    /**
     * @param UserInterface $user
     *
     * @return TokenInterface
     */
    public function setUser(UserInterface $user): TokenInterface
    {
        $this->user = $user;

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
     * @return TokenInterface
     */
    public function setType(string $type): TokenInterface
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     *
     * @return TokenInterface
     */
    public function setCreatedAt(\DateTime $createdAt): TokenInterface
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getExpiredAt(): \DateTime
    {
        return $this->expiredAt;
    }

    /**
     * @param \DateTime $expiredAt
     *
     * @return TokenInterface
     */
    public function setExpiredAt(\DateTime $expiredAt): TokenInterface
    {
        $this->expiredAt = $expiredAt;

        return $this;
    }

    /**
     * @return bool
     */
    public function isRevoked(): bool
    {
        return $this->revoked;
    }

    /**
     * @param bool $revoked
     *
     * @return TokenInterface
     */
    public function setRevoked(bool $revoked): TokenInterface
    {
        $this->revoked = $revoked;

        return $this;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @param string $value
     *
     * @return TokenInterface
     */
    public function setValue(string $value): TokenInterface
    {
        $this->value = $value;

        return $this;
    }
}
