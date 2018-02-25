<?php

namespace ZfbUser\Repository\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use ZfbUser\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use ZfbUser\Options\ModuleOptions;

/**
 * Class UserRepositoryFactory
 *
 * @package ZfbUser\Repository\Factory
 */
class UserRepositoryFactory implements FactoryInterface
{
    /**
     * @param \Interop\Container\ContainerInterface $container
     * @param string                                $requestedName
     * @param array|null                            $options
     *
     * @return \ZfbUser\Repository\UserRepository
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        /** @var EntityManagerInterface $entityManager */
        $entityManager = $container->get('doctrine.entitymanager.orm_default');

        /** @var ModuleOptions $moduleOptions */
        $moduleOptions = $container->get(ModuleOptions::class);

        $classMetadata = $entityManager->getClassMetadata($moduleOptions->getUserEntityClass());
        $repository = new UserRepository($entityManager, $classMetadata, $moduleOptions);

        return $repository;
    }
}
