<?php

namespace ZfbUser\Adapter;

use Zend\Authentication\Adapter\ValidatableAdapterInterface;
use ZfbUser\Entity\UserInterface;
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
     * Crypt credential
     *
     * @param string $credential
     *
     * @return string
     */
    public function cryptCredential(string $credential): string;

    /**
     * Verify credential
     *
     * @param string $hash
     * @param string $credential
     *
     * @return bool
     */
    public function verifyCredential(string $credential, string $hash): bool;
}
