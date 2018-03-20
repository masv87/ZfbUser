<?php

namespace ZfbUser\Controller;

use Zend\Http\PhpEnvironment\Request;
use Zend\Http\PhpEnvironment\Response;
use Zend\Mvc\Plugin\FlashMessenger\FlashMessenger;
use Zend\Form\Form;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;
use ZfbUser\Options\ModuleOptionsInterface;
use ZfbUser\Service\Exception\UserExistsException;
use ZfbUser\Service\UserService;

/**
 * Class UpdateUserController
 *
 * @method Plugin\ZfbAuthentication zfbAuthentication()
 * @method \Zend\Http\Response|array prg(string $redirect = null, bool $redirectToUrl = false)
 * @method FlashMessenger flashMessenger()
 *
 * @package ZfbUser\Controller
 */
class UpdateUserController extends AbstractActionController
{
    /**
     * @var Form
     */
    private $updateUserForm;

    /**
     * @var UserService
     */
    private $userService;

    /**
     * Параметры модуля
     *
     * @var ModuleOptionsInterface
     */
    private $moduleOptions;

    /**
     * UpdateUserController constructor.
     *
     * @param \Zend\Form\Form                         $updateUserForm
     * @param \ZfbUser\Service\UserService            $userService
     * @param \ZfbUser\Options\ModuleOptionsInterface $moduleOptions
     */
    public function __construct(Form $updateUserForm, UserService $userService, ModuleOptionsInterface $moduleOptions)
    {
        $this->updateUserForm = $updateUserForm;
        $this->userService = $userService;
        $this->moduleOptions = $moduleOptions;
    }

    /**
     * @return array|\Zend\Http\Response|\Zend\View\Model\ViewModel
     */
    public function indexAction()
    {
        if (!$this->zfbAuthentication()->hasIdentity()) {
            return $this->redirect()->toRoute('zfbuser/authentication');
        }

        $id = intval($this->params()->fromRoute('id', 0));
        $user = $this->userService->getAuthAdapter()->getRepository()->getUserById($id);

        if ($user == null) {
            return $this->notFoundAction();
        }

        $viewModel = new ViewModel([
            'form'    => $this->updateUserForm,
            'message' => null
        ]);

        /** @var \Zend\Http\PhpEnvironment\Request $request */
        $request = $this->getRequest();
        $url = $request->getRequestUri();
        $this->updateUserForm->setAttribute('action', $url);

        // Pass in the route/url you want to redirect to after the POST
        $prg = $this->prg($url, true);
        if ($prg instanceof \Zend\Http\PhpEnvironment\Response) {
            // Returned a response to redirect us.
            return $prg;
        }
        if ($prg === false) {
            // This wasn't a POST request, but there were no params in the flash
            // messenger; this is probably the first time the form was loaded.

            $this->updateUserForm->setData($user->getArrayCopy());

            return $viewModel;
        }

        // $prg is an array containing the POST params from the previous request

        $this->updateUserForm->setData($prg);
        if (!$this->updateUserForm->isValid()) {
            return $viewModel;
        }
        $data = $this->updateUserForm->getData();

        try {
            $user = $this->userService->saveUser($user, $data);
            $viewModel->setVariable('message', 'User ' . $user->getIdentity() . 'successfully updated!');
        } catch (UserExistsException | \Exception $ex) {
            $viewModel->setVariable('hasError', true);
            $viewModel->setVariable('message', $ex->getMessage());
        }

        return $viewModel;
    }

    /**
     * @return \Zend\Http\PhpEnvironment\Response|\Zend\View\Model\JsonModel
     */
    public function apiIndexAction()
    {
        /** @var Request $request */
        $request = $this->getRequest();

        /** @var Response $response */
        $response = $this->getResponse();
        if (!$request->isPost()) {
            $response->setStatusCode(Response::STATUS_CODE_405);

            return $response;
        }

        if (!$this->zfbAuthentication()->hasIdentity()) {
            $response->setStatusCode(Response::STATUS_CODE_403);

            return $response;
        }

        $id = intval($this->params()->fromRoute('id', 0));
        $user = $this->userService->getAuthAdapter()->getRepository()->getUserById($id);
        if ($user == null) {
            $response->setStatusCode(Response::STATUS_CODE_404);

            return $response;
        }

        $jsonModel = new JsonModel(['success' => false]);

        $post = $request->getPost();
        $this->updateUserForm->setData($post);
        if (!$this->updateUserForm->isValid()) {
            $jsonModel->setVariable('formErrors', $this->updateUserForm->getMessages());

            return $jsonModel;
        }
        $data = $this->updateUserForm->getData();

        try {
            $user = $this->userService->saveUser($user, $data);

            $jsonModel->setVariable('success', true);
            $jsonModel->setVariable('user', $user);
        } catch (\Exception $ex) {
            $jsonModel->setVariable('hasError', true);
            $jsonModel->setVariable('message', $ex->getMessage());
        }

        return $jsonModel;
    }
}
