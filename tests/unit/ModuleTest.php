<?php

namespace ZfbUserTest;

use Zend\Mvc\I18n\Translator;
use Zend\Validator\Translator\TranslatorInterface;
use Zend\Validator\AbstractValidator;
use ZfbUser\Module;
use Zend\Mvc\MvcEvent;
use Codeception\Module\ZF2;

/**
 * Class ModuleTest
 *
 * @package ZfbUserTest
 */
class ModuleTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    /**
     * @var Module
     */
    protected $module;

    /**
     * @var ZF2
     */
    protected $zf2;

    /**
     * @var MvcEvent
     */
    protected $mvcEvent;

    /**
     * @throws \Codeception\Exception\ModuleException
     */
    protected function _before()
    {
        $this->zf2 = $this->getModule('ZF2');

        /** @var \Zend\Mvc\Application $event */
        $event = $this->zf2->grabServiceFromContainer('Application');
        $this->mvcEvent = $event->getMvcEvent();

        $this->module = new Module();
    }

    /**
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function testOnBootstrapDefaultTranslator()
    {
        $oldTranslator = AbstractValidator::getDefaultTranslator();
        $this->module->onBootstrap($this->mvcEvent);
        $newTranslator = AbstractValidator::getDefaultTranslator();

        $this->tester->assertEquals($newTranslator, $oldTranslator);
        $this->tester->assertInstanceOf(Translator::class, $newTranslator);
    }

    /**
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function testOnBootstrapCustomTranslatorReplace()
    {
        AbstractValidator::setDefaultTranslator(new class implements TranslatorInterface
        {
            public function translate($message, $textDomain = 'default', $locale = null)
            {
                return '';
            }
        });

        $oldTranslator = AbstractValidator::getDefaultTranslator();
        $this->module->onBootstrap($this->mvcEvent);
        $newTranslator = AbstractValidator::getDefaultTranslator();

        $this->tester->assertNotEquals($newTranslator, $oldTranslator);
        $this->tester->assertInstanceOf(Translator::class, $newTranslator);
    }

    public function testGetConfig()
    {
        $this->tester->assertInternalType('array', $this->module->getConfig());
    }
}
