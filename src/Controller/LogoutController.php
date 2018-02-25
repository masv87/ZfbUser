<?php

namespace ZfbUser\Controller;

use Zend\Http\Response;
use Zend\Mvc\Controller\AbstractActionController;
use ZfbUser\Options\ModuleOptionsInterface;

/**
 * Class LogoutController
 *
 * @method Plugin\ZfbAuthentication zfbAuthentication()
 * @method Response|array prg(string $redirect = null, bool $redirectToUrl = false)
 *
 * @package ZfbUser\Controller
 */
class LogoutController extends AbstractActionController
{
    /**
     * Параметры модуля
     *
     * @var ModuleOptionsInterface
     */
    private $moduleOptions;

    /**
     * IndexController constructor.
     *
     * @param \ZfbUser\Options\ModuleOptionsInterface $moduleOptions
     */
    public function __construct(ModuleOptionsInterface $moduleOptions)
    {
        $this->moduleOptions = $moduleOptions;
    }

    /**
     * @return \Zend\Http\Response
     */
    public function logoutAction()
    {
        $this->zfbAuthentication()->getAuthService()->clearIdentity();

        return $this->redirect()->toRoute($this->moduleOptions->getLogoutCallbackRoute());
    }
}
