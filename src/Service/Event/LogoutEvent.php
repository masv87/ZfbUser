<?php

namespace ZfbUser\Service\Event;

use Zend\EventManager\Event;
use ZfbUser\Entity\UserInterface;

/**
 * Class LogoutEvent
 *
 * @package ZfbUser\Service\Event
 */
class LogoutEvent extends Event
{
    const EVENT_PRE = 'logout.pre';
    const EVENT_POST = 'logout.post';
    const EVENT_ERROR = 'logout.error';

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
     * @return null|\ZfbUser\Entity\UserInterface
     */
    public function getUser(): ?UserInterface
    {
        return $this->user;
    }

    /**
     * @param null|\ZfbUser\Entity\UserInterface $user
     *
     * @return \ZfbUser\Service\Event\LogoutEvent
     */
    public function setUser(?UserInterface $user): LogoutEvent
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
     * @return \ZfbUser\Service\Event\LogoutEvent
     */
    public function setDatetime(\DateTime $datetime): LogoutEvent
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
     * @return LogoutEvent
     */
    public function setType(string $type): LogoutEvent
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
     * @return \ZfbUser\Service\Event\LogoutEvent
     */
    public function setSuccess(?bool $success): LogoutEvent
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
     * @return LogoutEvent
     */
    public function setMessage(?string $message): LogoutEvent
    {
        $this->message = $message;
        $this->setParam('message', $this->message);

        return $this;
    }
}
