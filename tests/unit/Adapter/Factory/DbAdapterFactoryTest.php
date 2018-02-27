<?php

namespace ZfbUserTest;

use ZfbUser\Adapter\Factory\DbAdapterFactory;
use ZfbUser\Adapter\DbAdapter;
use Interop\Container\ContainerInterface;
use Codeception\Module\ZF2;

/**
 * Class DbAdapterFactoryTest
 *
 * @package ZfbUserTest
 */
class DbAdapterFactoryTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    /**
     * @var ZF2
     */
    protected $zf2;

    /**
     * @throws \Codeception\Exception\ModuleException
     */
    protected function _before()
    {
        $this->zf2 = $this->getModule('ZF2');
    }

    /**
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function testFactoryCorrect()
    {
        /** @var ContainerInterface $sm */
        $sm = $this->zf2->grabServiceFromContainer('ServiceManager');
        $requestedName = 'zfbuser_authentication_adapter';
        $options = null;

        $factory = new DbAdapterFactory();
        $adapter = $factory->__invoke($sm, $requestedName, $options);
        $this->tester->assertInstanceOf(DbAdapter::class, $adapter);
    }
}
