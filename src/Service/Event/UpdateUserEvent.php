<?php

namespace ZfbUser\Service\Event;

use Zend\EventManager\Event;
use ZfbUser\Entity\UserInterface;

/**
 * Class UpdateUserEvent
 *
 * @package ZfbUser\Service\Event
 */
class UpdateUserEvent extends Event
{
    const EVENT_PRE = 'updateUser.pre';
    const EVENT_POST = 'updateUser.post';
    const EVENT_ERROR = 'updateUser.error';

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
     * @return \ZfbUser\Service\Event\UpdateUserEvent
     */
    public function setUser(UserInterface $user): UpdateUserEvent
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
     * @return \ZfbUser\Service\Event\UpdateUserEvent
     */
    public function setFormData(array $formData): UpdateUserEvent
    {
        $this->formData = $formData;
        $this->setParam('formData', $this->formData);

        return $this;
    }
}
