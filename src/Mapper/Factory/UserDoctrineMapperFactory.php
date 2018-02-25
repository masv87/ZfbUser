<?php

namespace ZfbUser\Mapper\Factory;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;
use ZfbUser\Mapper\UserDoctrineMapper;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class UserDoctrineMapperFactory
 *
 * @package ZfbUser\Mapper\Factory
 */
class UserDoctrineMapperFactory implements FactoryInterface
{
    /**
     * @param \Interop\Container\ContainerInterface $container
     * @param string                                $requestedName
     * @param array|null                            $options
     *
     * @return \ZfbUser\Mapper\UserDoctrineMapper
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        /** @var EntityManagerInterface $entityManager */
        $entityManager = $container->get('doctrine.entitymanager.orm_default');

        $mapper = new UserDoctrineMapper($entityManager);

        return $mapper;
    }
}
