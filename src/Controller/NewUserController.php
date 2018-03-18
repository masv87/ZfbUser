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
 * Class NewUserController
 *
 * @method Plugin\ZfbAuthentication zfbAuthentication()
 * @method \Zend\Http\Response|array prg(string $redirect = null, bool $redirectToUrl = false)
 * @method FlashMessenger flashMessenger()
 *
 * @package ZfbUser\Controller
 */
class NewUserController extends AbstractActionController
{
    /**
     * @var Form
     */
    private $newUserForm;

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
     * NewUserController constructor.
     *
     * @param \Zend\Form\Form                         $newUserForm
     * @param \ZfbUser\Service\UserService            $userService
     * @param \ZfbUser\Options\ModuleOptionsInterface $moduleOptions
     */
    public function __construct(Form $newUserForm, UserService $userService, ModuleOptionsInterface $moduleOptions)
    {
        $this->newUserForm = $newUserForm;
        $this->userService = $userService;
        $this->moduleOptions = $moduleOptions;
    }

    /**
     * @return array|\Zend\Http\Response|\Zend\View\Model\ViewModel
     * @throws \ReflectionException
     * @throws \ZfbUser\Service\Exception\EventResultException
     * @throws \ZfbUser\Service\Exception\MailTemplateNotFoundException
     * @throws \ZfbUser\Service\Exception\UnsupportedTokenTypeException
     */
    public function indexAction()
    {
        if (!$this->zfbAuthentication()->hasIdentity()) {
            return $this->redirect()->toRoute('zfbuser/authentication');
        }

        $viewModel = new ViewModel([
            'form'    => $this->newUserForm,
            'message' => null
        ]);

        /** @var \Zend\Http\PhpEnvironment\Request $request */
        $request = $this->getRequest();
        $url = $request->getRequestUri();
        $this->newUserForm->setAttribute('action', $url);

        // Pass in the route/url you want to redirect to after the POST
        $prg = $this->prg($url, true);
        if ($prg instanceof \Zend\Http\PhpEnvironment\Response) {
            // Returned a response to redirect us.
            return $prg;
        }
        if ($prg === false) {
            // This wasn't a POST request, but there were no params in the flash
            // messenger; this is probably the first time the form was loaded.
            return $viewModel;
        }

        // $prg is an array containing the POST params from the previous request

        $this->newUserForm->setData($prg);
        if (!$this->newUserForm->isValid()) {
            return $viewModel;
        }
        $data = $this->newUserForm->getData();

        try {
            $user = $this->userService->addUser($data);
            $viewModel->setVariable('message', 'User ' . $user->getIdentity() . 'successfully added!');
        } catch (UserExistsException $ex) {
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

        $jsonModel = new JsonModel(['success' => false]);

        $post = $request->getPost();
        $this->newUserForm->setData($post);
        if (!$this->newUserForm->isValid()) {
            $jsonModel->setVariable('formErrors', $this->newUserForm->getMessages());

            return $jsonModel;
        }
        $data = $this->newUserForm->getData();

        try {
            $user = $this->userService->addUser($data);

            //TODO: return saved data
            $jsonModel->setVariable('user', $user);

            $jsonModel->setVariable('success', true);
        } catch (\Exception $ex) {
            $jsonModel->setVariable('hasError', true);
            $jsonModel->setVariable('message', $ex->getMessage());
        }

        return $jsonModel;
    }
}
