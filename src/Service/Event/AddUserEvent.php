<?php

namespace ZfbUser\Service\Event;

use Zend\EventManager\Event;
use ZfbUser\Entity\UserInterface;

/**
 * Class AddUserEvent
 *
 * @package ZfbUser\Service\Event
 */
class AddUserEvent extends Event
{
    const EVENT_PRE = 'addUser.pre';
    const EVENT_POST = 'addUser.post';
    const EVENT_ERROR = 'addUser.error';

    /**
     * @var UserInterface
     */
    protected $user;

    /**
     * Form data
     *
     * @var array
     */
    protected $formData;

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
     * @return \ZfbUser\Service\Event\AddUserEvent
     */
    public function setUser(UserInterface $user): AddUserEvent
    {
        $this->user = $user;
        $this->setParam('user', $user);

        return $this;
    }

    /**
     * @return array
     */
    public function getFormData(): array
    {
        return $this->formData;
    }

    /**
     * @param array $formData
     *
     * @return \ZfbUser\Service\Event\AddUserEvent
     */
    public function setFormData(array $formData): AddUserEvent
    {
        $this->formData = $formData;
        $this->setParam('formData', $this->formData);

        return $this;
    }
}
