<?php

namespace ZfbUser\Service\Event;

use Zend\EventManager\Event;
use ZfbUser\Entity\UserInterface;

/**
 * Class AuthenticateEvent
 *
 * @package ZfbUser\Service\Event
 */
class AuthenticateEvent extends Event
{
    const EVENT_PRE = 'authenticate.pre';
    const EVENT_POST = 'authenticate.post';
    const EVENT_ERROR = 'authenticate.error';

    /**
     * @var UserInterface|null
     */
    protected $user;

    /**
     * @var \DateTime
     */
    protected $datetime;

    /**
     * @var string
     */
    protected $type;

    /**
     * @var boolean|null
     */
    protected $success;

    /**
     * @var string|null
     */
    protected $message;

    /**
     * @return \ZfbUser\Entity\UserInterface|null
     */
    public function getUser(): ?UserInterface
    {
        return $this->user;
    }

    /**
     * @param null|\ZfbUser\Entity\UserInterface $user
     *
     * @return \ZfbUser\Service\Event\AuthenticateEvent
     */
    public function setUser(?UserInterface $user): AuthenticateEvent
    {
        $this->user = $user;
        $this->setParam('user', $user);

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
     * @return \ZfbUser\Service\Event\AuthenticateEvent
     */
    public function setDatetime(\DateTime $datetime): AuthenticateEvent
    {
        $this->datetime = $datetime;
        $this->setParam('datetime', $this->datetime);

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
     * @return AuthenticateEvent
     */
    public function setType(string $type): AuthenticateEvent
    {
        $this->type = $type;
        $this->setParam('type', $this->type);

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
     * @return \ZfbUser\Service\Event\AuthenticateEvent
     */
    public function setSuccess(?bool $success): AuthenticateEvent
    {
        $this->success = $success;
        $this->setParam('success', $this->success);

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
     * @return AuthenticateEvent
     */
    public function setMessage(?string $message): AuthenticateEvent
    {
        $this->message = $message;
        $this->setParam('message', $this->message);

        return $this;
    }
}
