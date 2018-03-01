<?php

namespace ZfbUser\EventProvider;

use Zend\EventManager\Event;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\EventManager;
use Zend\EventManager\EventManagerAwareInterface;
use ZfbUser\Service\Exception;

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

    /**
     * @param \Zend\EventManager\Event $event
     *
     * @throws \ZfbUser\Service\Exception\EventResultException
     */
    protected function trigger(Event $event): void
    {
        $callback = function ($result) {
            return ($result instanceof EventResultInterface && $result->hasError() === true);
        };

        $results = $this->getEventManager()->triggerEventUntil($callback, $event);

        if ($results->stopped()) {
            $last = $results->last();
            if (!$last instanceof EventResultInterface) {
                throw new Exception\EventResultException();
            }

            if ($last->hasError()) {
                throw new Exception\EventResultException($last->getErrorMessage());
            }
        }
    }
}
