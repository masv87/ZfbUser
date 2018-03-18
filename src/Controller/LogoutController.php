<?php

namespace ZfbUser\Controller;

use Zend\Http\PhpEnvironment\Request;
use Zend\Http\PhpEnvironment\Response;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;
use ZfbUser\Options\ModuleOptionsInterface;

/**
 * Class LogoutController
 *
 * @method Plugin\ZfbAuthentication zfbAuthentication()
 * @method \Zend\Http\Response|array prg(string $redirect = null, bool $redirectToUrl = false)
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

    /**
     * @return \Zend\Http\PhpEnvironment\Response|\Zend\View\Model\JsonModel
     */
    public function apiLogoutAction()
    {
        sleep(2);

        /** @var Response $response */
        $response = $this->getResponse();

        /** @var Request $request */
        $request = $this->getRequest();

        if (!$request->isPost()) {
            $response->setStatusCode(Response::STATUS_CODE_405);

            return $response;
        }

        $this->zfbAuthentication()->getAuthService()->clearIdentity();

        $jsonModel = new JsonModel([
            'success'             => true,
            'logout_callback_url' => $this->url()->fromRoute($this->moduleOptions->getLogoutCallbackRoute()),
        ]);

        return $jsonModel;
    }
}
