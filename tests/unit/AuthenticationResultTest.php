<?php

namespace ZfbUserTest;

use ZfbUser\AuthenticationResult;
use ZfbUser\Entity\User as UserEntity;

/**
 * Class AuthenticationResultTest
 */
class AuthenticationResultTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    public function testCodeReturnCorrect()
    {
        $code = \Zend\Authentication\Result::SUCCESS;
        $result = new AuthenticationResult($code, null, []);

        $this->tester->assertEquals($result->getCode(), $code);
    }

    public function testIdentityReturnNull()
    {
        $result = new AuthenticationResult(1, null, []);

        $this->tester->assertNull($result->getIdentity());
    }

    public function testIdentityReturnCorrect()
    {
        $entity = new UserEntity();
        $entity->setId(1)->setIdentity('entity');
        $result = new AuthenticationResult(1, $entity, []);

        $this->tester->assertNotNull($result->getIdentity());
        $this->tester->assertEquals($result->getIdentity(), $entity);
    }
}
