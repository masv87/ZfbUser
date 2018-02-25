<?php

namespace ZfbUser\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="ZfbUser\Repository\UserRepository")
 * @ORM\Table(name="zfb_users")
 */
class User implements UserInterface
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
     * E-mail - Идентификатор
     *
     * @var string
     * @ORM\Column(name="identity", type="string", unique=true, length=50, nullable=false)
     */
    protected $identity;

    /**
     * Пароль
     *
     * @var string
     * @ORM\Column(name="credential", type="string", length=128, nullable=false)
     */
    protected $credential;

    /**
     * Подтвержден E-mail?
     *
     * @var bool
     * @ORM\Column(name="identity_confirmed", type="boolean", nullable=false, options={"default"=0})
     */
    protected $identityConfirmed = false;

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
     * @return \ZfbUser\Entity\UserInterface
     */
    public function setId(int $id): UserInterface
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getIdentity(): string
    {
        return $this->identity;
    }

    /**
     * @param string $identity
     *
     * @return \ZfbUser\Entity\UserInterface
     */
    public function setIdentity(string $identity): UserInterface
    {
        $this->identity = $identity;

        return $this;
    }

    /**
     * @return string
     */
    public function getCredential(): string
    {
        return $this->credential;
    }

    /**
     * @param string $credential
     *
     * @return \ZfbUser\Entity\UserInterface
     */
    public function setCredential(string $credential): UserInterface
    {
        $this->credential = $credential;

        return $this;
    }

    /**
     * @return bool
     */
    public function isIdentityConfirmed(): bool
    {
        return $this->identityConfirmed;
    }

    /**
     * @param bool $emailConfirmed
     *
     * @return \ZfbUser\Entity\UserInterface
     */
    public function setIdentityConfirmed(bool $emailConfirmed): UserInterface
    {
        $this->identityConfirmed = $emailConfirmed;

        return $this;
    }

    /**
     * @return string
     */
    public function getDisplayName(): string
    {
        return $this->identity;
    }
}
