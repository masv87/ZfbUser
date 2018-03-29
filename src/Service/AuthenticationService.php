<?php

namespace ZfbUser\Service;

use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\EventManager;
use Zend\EventManager\EventManagerAwareInterface;
use Zend\Authentication\Storage\StorageInterface;
use ZfbUser\Entity\UserInterface;
use ZfbUser\Adapter\AdapterInterface;
use ZfbUser\EventProvider\EventResultInterface;
use ZfbUser\Options\ModuleOptions;
use ZfbUser\Entity\Log as LogEntity;

/**
 * Class AuthenticationService
 *
 * @package ZfbUser\Service
 */
class AuthenticationService extends \Zend\Authentication\AuthenticationService implements EventManagerAwareInterface
{
    /**
     * @var UserInterface|null
     */
    protected $identity;

    /**
     * @var null|\ZfbUser\Adapter\AdapterInterface
     */
    protected $adapter;

    /**
     * @var ModuleOptions
     */
    protected $moduleOptions;

    /**
     * @var EventManagerInterface
     */
    protected $events;

    /**
     * AuthenticationService constructor.
     *
     * @param null|\Zend\Authentication\Storage\StorageInterface $storage
     * @param null|\ZfbUser\Adapter\AdapterInterface             $adapter
     * @param \ZfbUser\Options\ModuleOptions                     $moduleOptions
     */
    public function __construct(?StorageInterface $storage, ?AdapterInterface $adapter, ModuleOptions $moduleOptions)
    {
        $this->moduleOptions = $moduleOptions;

        parent::__construct($storage, $adapter);
    }

    /**
     * @return \ZfbUser\Adapter\AdapterInterface
     */
    public function getAdapter(): AdapterInterface
    {
        return $this->adapter;
    }

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
    protected function trigger(\Zend\EventManager\Event $event): void
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

    /**
     * @param \Zend\Authentication\Adapter\AdapterInterface|null $adapter
     *
     * @return \Zend\Authentication\Result
     * @throws \Exception
     * @throws \ZfbUser\Service\Exception\EventResultException
     */
    public function authenticate(\Zend\Authentication\Adapter\AdapterInterface $adapter = null)
    {
        $eventPre = new Event\AuthenticateEvent(Event\AuthenticateEvent::EVENT_PRE, $this);
        $eventPre
            ->setUser(null)
            ->setDatetime(new \DateTime())
            ->setType(LogEntity::TYPE_AUTHENTICATE)
            ->setSuccess(null)
            ->setMessage(LogEntity::TYPE_AUTHENTICATE . '.' . Event\AuthenticateEvent::EVENT_PRE);
        $this->trigger($eventPre);

        try {
            $result = parent::authenticate($adapter);

            $eventPost = new Event\AuthenticateEvent(Event\AuthenticateEvent::EVENT_POST, $this);
            $eventPost
                ->setUser($result->getIdentity())
                ->setDatetime(new \DateTime())
                ->setType(LogEntity::TYPE_AUTHENTICATE)
                ->setSuccess($result->isValid())
                ->setMessage(LogEntity::TYPE_AUTHENTICATE . '.' . Event\AuthenticateEvent::EVENT_POST);
            $this->trigger($eventPost);

            return $result;
        } catch (\Exception $ex) {
            $eventError = new Event\AuthenticateEvent(Event\AuthenticateEvent::EVENT_ERROR, $this);
            $eventError->setUser(null)
                ->setDatetime(new \DateTime())
                ->setType(LogEntity::TYPE_AUTHENTICATE)
                ->setSuccess(false)
                ->setMessage(LogEntity::TYPE_AUTHENTICATE . '.' . Event\AuthenticateEvent::EVENT_ERROR);
            $this->trigger($eventError);

            throw $ex;
        }
    }

    /**
     * @throws \ZfbUser\Service\Exception\EventResultException
     */
    public function clearIdentity()
    {
        $eventPre = new Event\LogoutEvent(Event\LogoutEvent::EVENT_PRE, $this);
        $eventPre
            ->setUser($this->getIdentity())
            ->setDatetime(new \DateTime())
            ->setType(LogEntity::TYPE_LOGOUT)
            ->setSuccess(null)
            ->setMessage(LogEntity::TYPE_LOGOUT . '.' . Event\LogoutEvent::EVENT_PRE);
        $this->trigger($eventPre);

        parent::clearIdentity();

        $eventPost = new Event\LogoutEvent(Event\LogoutEvent::EVENT_POST, $this);
        $eventPost
            ->setUser(null)
            ->setDatetime(new \DateTime())
            ->setType(LogEntity::TYPE_LOGOUT)
            ->setSuccess(true)
            ->setMessage(LogEntity::TYPE_LOGOUT . '.' . Event\LogoutEvent::EVENT_POST);
        $this->trigger($eventPost);
    }

    /**
     * @param bool $reload
     *
     * @return null|\ZfbUser\Entity\UserInterface
     */
    public function getIdentity(bool $reload = true): ?UserInterface
    {
        if (!$this->identity) {
            $this->identity = parent::getIdentity();

            if (!empty($this->identity) && is_string($this->identity)) {
                $this->identity = $this->getAdapter()->getRepository()->getUserByIdentity($this->identity);
            } elseif ($this->identity !== null && $reload === true) {
                $this->identity = $this->getAdapter()->getRepository()->getUserByIdentity($this->identity->getIdentity());
            }

        }

        return $this->identity;
    }
}
