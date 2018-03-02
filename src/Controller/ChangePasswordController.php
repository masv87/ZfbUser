<?php

namespace ZfbUser\Controller;

use Zend\Form\Form;
use Zend\Http\Response;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use ZfbUser\AuthenticationResult;
use ZfbUser\Options\ModuleOptionsInterface;
use ZfbUser\Service\UserService;

/**
 * Class ChangePasswordController
 *
 * @method Plugin\ZfbAuthentication zfbAuthentication()
 * @method Response|array prg(string $redirect = null, bool $redirectToUrl = false)
 *
 * @package ZfbUser\Controller
 */
class ChangePasswordController extends AbstractActionController
{
    /**
     * @var Form
     */
    private $changePasswordForm;

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
     * ChangePasswordController constructor.
     *
     * @param \Zend\Form\Form                         $changePasswordForm
     * @param \ZfbUser\Service\UserService            $userService
     * @param \ZfbUser\Options\ModuleOptionsInterface $moduleOptions
     */
    public function __construct(Form $changePasswordForm, UserService $userService, ModuleOptionsInterface $moduleOptions)
    {
        $this->changePasswordForm = $changePasswordForm;
        $this->userService = $userService;
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

        $user = $this->zfbAuthentication()->getIdentity();

        $viewModel = new ViewModel([
            'user' => $user,
            'form' => $this->changePasswordForm,
        ]);

        /** @var \Zend\Http\PhpEnvironment\Request $request */
        $request = $this->getRequest();
        $url = $request->getRequestUri();
        $this->changePasswordForm->setAttribute('action', $url);
        $this->changePasswordForm->get('identity')->setValue($user->getIdentity());

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

        $this->changePasswordForm->setData($prg);
        if (!$this->changePasswordForm->isValid()) {
            return $viewModel;
        }
        $data = $this->changePasswordForm->getData();
        $credentialOldFieldName = $this->moduleOptions->getChangePasswordFormOptions()->getCredentialOldFieldName();
        $credentialFieldName = $this->moduleOptions->getChangePasswordFormOptions()->getCredentialFieldName();
        $identity = $data['identity'];
        $oldPassword = $data[$credentialOldFieldName];
        $newPassword = $data[$credentialFieldName];

        $result = $this->userService->changePassword($identity, $oldPassword, $newPassword);

        if (!$result->isValid() && $result->getCode() == AuthenticationResult::FAILURE_IDENTITY_NOT_CONFIRMED) {
            $query = http_build_query(['identity' => $identity]);

            return $this->redirect()->toRoute('zfbuser/confirmation', ['action' => 'index'], ['query' => $query]);
        }

        $viewModel->setVariable('authResult', $result);

        return $viewModel;
    }
}
