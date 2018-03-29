<?php

namespace ZfbUser\Mapper\Factory;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;
use ZfbUser\Mapper\LogDoctrineMapper;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class LogDoctrineMapperFactory
 *
 * @package ZfbUser\Mapper\Factory
 */
class LogDoctrineMapperFactory implements FactoryInterface
{
    /**
     * @param \Interop\Container\ContainerInterface $container
     * @param string                                $requestedName
     * @param array|null                            $options
     *
     * @return object|\ZfbUser\Mapper\LogDoctrineMapper
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        /** @var EntityManagerInterface $entityManager */
        $entityManager = $container->get('doctrine.entitymanager.orm_default');

        $mapper = new LogDoctrineMapper($entityManager);

        return $mapper;
    }
}
