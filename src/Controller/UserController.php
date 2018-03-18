<?php

namespace ZfbUser\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;
use ZfbUser\Options\ModuleOptionsInterface;
use Zend\Http\PhpEnvironment\Response;
use Zend\Http\PhpEnvironment\Request;

/**
 * Class UserController
 *
 * @method Plugin\ZfbAuthentication zfbAuthentication()
 * @method \Zend\Http\Response|array prg(string $redirect = null, bool $redirectToUrl = false)
 *
 * @package ZfbUser\Controller
 */
class UserController extends AbstractActionController
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
     * @return \Zend\Http\Response|\Zend\View\Model\ViewModel
     */
    public function indexAction()
    {
        if (!$this->zfbAuthentication()->hasIdentity()) {
            return $this->redirect()->toRoute('zfbuser/authentication');
        }

        $viewModel = new ViewModel([
            'user' => $this->zfbAuthentication()->getIdentity(),
        ]);

        return $viewModel;
    }

    /**
     * @return \Zend\Http\PhpEnvironment\Response|\Zend\View\Model\JsonModel
     */
    public function apiIndexAction()
    {
        /** @var Response $response */
        $response = $this->getResponse();

        /** @var Request $request */
        $request = $this->getRequest();

        if (!$request->isPost()) {
            $response->setStatusCode(Response::STATUS_CODE_405);

            return $response;
        }

        if (!$this->zfbAuthentication()->hasIdentity()) {
            $response->setStatusCode(Response::STATUS_CODE_403);

            return $response;
        }

        $jsonModel = new JsonModel([
            'user' => $this->zfbAuthentication()->getIdentity(),
        ]);

        return $jsonModel;
    }
}
