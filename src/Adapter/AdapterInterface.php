<?php

namespace ZfbUser\Adapter;

use Zend\Authentication\Adapter\ValidatableAdapterInterface;
use ZfbUser\Mapper\UserMapperInterface;
use ZfbUser\Options\ModuleOptionsInterface;
use ZfbUser\Repository\UserRepositoryInterface;

/**
 * Interface AdapterInterface
 *
 * @package ZfbUser\Adapter
 */
interface AdapterInterface extends ValidatableAdapterInterface
{
    /**
     * @return ModuleOptionsInterface
     */
    public function getModuleOptions(): ModuleOptionsInterface;

    /**
     * @return UserMapperInterface
     */
    public function getMapper(): UserMapperInterface;

    /**
     * @return UserRepositoryInterface
     */
    public function getRepository(): UserRepositoryInterface;

    /**
     * @param string $credential
     *
     * @return string
     */
    public function cryptCredential(string $credential): string;
}
