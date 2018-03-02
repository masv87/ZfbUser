<?php

namespace ZfbUser\Controller;

use Zend\Mvc\Plugin\FlashMessenger\FlashMessenger;
use Zend\Form\Form;
use Zend\Http\Response;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use ZfbUser\Options\ModuleOptionsInterface;
use ZfbUser\Service\Exception\UserExistsException;
use ZfbUser\Service\UserService;

/**
 * Class NewUserController
 *
 * @method Plugin\ZfbAuthentication zfbAuthentication()
 * @method Response|array prg(string $redirect = null, bool $redirectToUrl = false)
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
     * @var Form
     */
    private $setPasswordForm;

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
     * @param \Zend\Form\Form                         $setPasswordForm
     * @param \ZfbUser\Service\UserService            $userService
     * @param \ZfbUser\Options\ModuleOptionsInterface $moduleOptions
     */
    public function __construct(Form $newUserForm, Form $setPasswordForm, UserService $userService, ModuleOptionsInterface $moduleOptions)
    {
        $this->newUserForm = $newUserForm;
        $this->setPasswordForm = $setPasswordForm;
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
     * @return \Zend\Http\Response|\Zend\View\Model\ViewModel
     */
    public function setPasswordAction()
    {
        if ($this->zfbAuthentication()->hasIdentity()) {
            return $this->redirect()->toRoute('zfbuser/authentication');
        }

        /** @var \Zend\Http\PhpEnvironment\Request $request */
        $request = $this->getRequest();

        $viewModel = new ViewModel([
            'form'       => $this->setPasswordForm,
            'identity'   => null,
            'authResult' => null,
        ]);

        $identityFieldName = $this->moduleOptions->getSetPasswordFormOptions()->getIdentityFieldName();

        if (!$request->isPost()) {
            $identity = $this->params()->fromQuery('identity', null);
            $code = $this->params()->fromQuery('code', null);
            if (empty($identity) || empty($code)) {
                return $this->redirect()->toRoute('zfbuser/authentication');
            }

            $this->setPasswordForm->get($identityFieldName)->setValue($identity);
            $this->setPasswordForm->get('code')->setValue($code);
            $viewModel->setVariable('identity', $identity);

            return $viewModel;
        }

        $this->setPasswordForm->setData($request->getPost());
        if (!$this->setPasswordForm->isValid()) {
            return $viewModel;
        }

        $data = $this->setPasswordForm->getData();
        $credentialFieldName = $this->moduleOptions->getSetPasswordFormOptions()->getCredentialFieldName();
        $newPassword = $data[$credentialFieldName];
        $identity = $data[$identityFieldName];
        $code = $data['code'];
        $result = $this->userService->setPassword($identity, $code, $newPassword);

        if (!$result->isValid()) {
            $viewModel->setVariable('authResult', $result);

            return $viewModel;
        }

        $query = http_build_query([
            'identity'        => $identity,
            'passwordChanged' => 1,
        ]);

        return $this->redirect()->toRoute('zfbuser/authentication', [], ['query' => $query]);
    }
}
