<?php

namespace ZfbUser\Service;

use Zend\Authentication\Storage\StorageInterface;
use ZfbUser\Entity\UserInterface;
use ZfbUser\Adapter\AdapterInterface;

/**
 * Class AuthenticationService
 *
 * @package ZfbUser\Service
 */
class AuthenticationService extends \Zend\Authentication\AuthenticationService
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
     * AuthenticationService constructor.
     *
     * @param null|\Zend\Authentication\Storage\StorageInterface $storage
     * @param null|\ZfbUser\Adapter\AdapterInterface             $adapter
     */
    public function __construct(?StorageInterface $storage, ?AdapterInterface $adapter)
    {
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
            } elseif ($reload === true) {
                $this->identity = $this->getAdapter()->getRepository()->getUserByIdentity($this->identity->getIdentity());
            }

        }

        return $this->identity;
    }
}
