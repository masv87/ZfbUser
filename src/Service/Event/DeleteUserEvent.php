<?php

namespace ZfbUser\Service\Event;

use Zend\EventManager\Event;
use ZfbUser\Entity\UserInterface;

/**
 * Class DeleteUserEvent
 *
 * @package ZfbUser\Service\Event
 */
class DeleteUserEvent extends Event
{
    const EVENT_PRE = 'deleteUser.pre';
    const EVENT_POST = 'deleteUser.post';
    const EVENT_ERROR = 'deleteUser.error';

    /**
     * @var UserInterface
     */
    protected $user;

    /**
     * @return \ZfbUser\Entity\UserInterface
     */
    public function getUser(): UserInterface
    {
        return $this->user;
    }

    /**
     * @param \ZfbUser\Entity\UserInterface $user
     *
     * @return \ZfbUser\Service\Event\DeleteUserEvent
     */
    public function setUser(UserInterface $user): DeleteUserEvent
    {
        $this->user = $user;
        $this->setParam('user', $user);

        return $this;
    }
}
