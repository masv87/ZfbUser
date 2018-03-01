<?php

namespace ZfbUser\EventProvider;

use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\EventManager;
use Zend\EventManager\EventManagerAwareInterface;

/**
 * Class EventProvider
 *
 * @package ZfbUser\EventProvider
 */
abstract class EventProvider implements EventManagerAwareInterface
{
    /**
     * @var EventManagerInterface
     */
    protected $events;

    /**
     * @param \Zend\EventManager\EventManagerInterface $events
     *
     * @return $this
     */
    public function setEventManager(EventManagerInterface $events)
    {
        $events->setIdentifiers([__CLASS__, get_called_class(),]);

        $this->events = $events;

        return $this;
    }

    /**
     * @return \Zend\EventManager\EventManagerInterface
     */
    public function getEventManager()
    {
        if (null === $this->events) {
            $this->setEventManager(new EventManager());
        }

        return $this->events;
    }
}
