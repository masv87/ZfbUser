<?php

namespace ZfbUser\Adapter;

use Zend\Authentication\Adapter\AbstractAdapter as ZendAbstractAdapter;
use ZfbUser\Mapper\UserMapperInterface;
use ZfbUser\Options\ModuleOptionsInterface;
use ZfbUser\Repository\UserRepositoryInterface;

/**
 * Class AbstractAdapter
 *
 * @package ZfbUser\Adapter
 */
abstract class AbstractAdapter extends ZendAbstractAdapter implements AdapterInterface
{
    /**
     * @var ModuleOptionsInterface
     */
    protected $moduleOptions;

    /**
     * @var UserMapperInterface
     */
    protected $mapper;

    /**
     * @var UserRepositoryInterface
     */
    protected $repository;

    /**
     * AbstractAdapter constructor.
     *
     * @param \ZfbUser\Options\ModuleOptionsInterface     $moduleOptions
     * @param \ZfbUser\Mapper\UserMapperInterface         $mapper
     * @param \ZfbUser\Repository\UserRepositoryInterface $repository
     */
    public function __construct(
        ModuleOptionsInterface $moduleOptions,
        UserMapperInterface $mapper,
        UserRepositoryInterface $repository
    ) {
        $this->moduleOptions = $moduleOptions;
        $this->mapper = $mapper;
        $this->repository = $repository;
    }

    /**
     * @return ModuleOptionsInterface
     */
    public function getModuleOptions(): ModuleOptionsInterface
    {
        return $this->moduleOptions;
    }

    /**
     * @return UserMapperInterface
     */
    public function getMapper(): UserMapperInterface
    {
        return $this->mapper;
    }

    /**
     * @return UserRepositoryInterface
     */
    public function getRepository(): UserRepositoryInterface
    {
        return $this->repository;
    }
}
