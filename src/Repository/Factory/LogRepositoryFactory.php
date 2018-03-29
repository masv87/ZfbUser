<?php

namespace ZfbUser\Repository\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use ZfbUser\Repository\LogRepository;
use Doctrine\ORM\EntityManagerInterface;
use ZfbUser\Options\ModuleOptions;

/**
 * Class LogRepositoryFactory
 *
 * @package ZfbUser\Repository\Factory
 */
class LogRepositoryFactory implements FactoryInterface
{
    /**
     * @param \Interop\Container\ContainerInterface $container
     * @param string                                $requestedName
     * @param array|null                            $options
     *
     * @return object|\ZfbUser\Repository\LogRepository
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        /** @var EntityManagerInterface $entityManager */
        $entityManager = $container->get('doctrine.entitymanager.orm_default');

        /** @var ModuleOptions $moduleOptions */
        $moduleOptions = $container->get(ModuleOptions::class);

        $classMetadata = $entityManager->getClassMetadata($moduleOptions->getLogEntityClass());
        $repository = new LogRepository($entityManager, $classMetadata, $moduleOptions);

        return $repository;
    }
}
