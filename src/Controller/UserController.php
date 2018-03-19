<?php

namespace ZfbUser\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;
use ZfbUser\Options\ModuleOptionsInterface;
use Zend\Http\PhpEnvironment\Response;
use Zend\Http\PhpEnvironment\Request;
use ZfbUser\Repository\UserRepositoryInterface;

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
     * @var UserRepositoryInterface
     */
    private $userRepository;

    /**
     * UserController constructor.
     *
     * @param \ZfbUser\Options\ModuleOptionsInterface     $moduleOptions
     * @param \ZfbUser\Repository\UserRepositoryInterface $userRepository
     */
    public function __construct(ModuleOptionsInterface $moduleOptions, UserRepositoryInterface $userRepository)
    {
        $this->moduleOptions = $moduleOptions;
        $this->userRepository = $userRepository;
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
            'success' => true,
            'user'    => $this->zfbAuthentication()->getIdentity(),
        ]);

        return $jsonModel;
    }

    public function apiGetAction()
    {
        $identity = $this->params()->fromRoute('identity', null);

        /** @var Response $response */
        $response = $this->getResponse();

        /** @var Request $request */
        $request = $this->getRequest();

        if (!$request->isGet()) {
            $response->setStatusCode(Response::STATUS_CODE_405);

            return $response;
        }

        if (!$this->zfbAuthentication()->hasIdentity()) {
            $response->setStatusCode(Response::STATUS_CODE_403);

            return $response;
        }

        if (empty($identity)) {
            return $this->notFoundAction();
        }

        $user = $this->userRepository->getUserByIdentity($identity);

        if ($user == null) {
            return $this->notFoundAction();
        }

        $jsonModel = new JsonModel([
            'success' => true,
            'user'    => $user,
        ]);

        return $jsonModel;
    }
}
