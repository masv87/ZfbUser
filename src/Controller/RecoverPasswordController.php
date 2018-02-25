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
 * Class RecoverPasswordController
 *
 * @method Plugin\ZfbAuthentication zfbAuthentication()
 * @method Response|array prg(string $redirect = null, bool $redirectToUrl = false)
 *
 * @package ZfbUser\Controller
 */
class RecoverPasswordController extends AbstractActionController
{
    /**
     * @var Form
     */
    private $recoverPasswordForm;

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
     * RecoverPasswordController constructor.
     *
     * @param \Zend\Form\Form                         $recoverForm
     * @param \Zend\Form\Form                         $changeForm
     * @param \ZfbUser\Service\UserService            $userService
     * @param \ZfbUser\Options\ModuleOptionsInterface $moduleOptions
     */
    public function __construct(
        Form $recoverForm,
        Form $changeForm,
        UserService $userService,
        ModuleOptionsInterface $moduleOptions
    ) {
        $this->recoverPasswordForm = $recoverForm;
        $this->changePasswordForm = $changeForm;
        $this->userService = $userService;
        $this->moduleOptions = $moduleOptions;
    }

    /**
     * @return array|\Zend\Http\Response|\Zend\View\Model\ViewModel
     * @throws \ZfbUser\Service\Exception\TemplateNotFoundException
     * @throws \ZfbUser\Service\Exception\UnsupportedTokenTypeException
     */
    public function indexAction()
    {
        if ($this->zfbAuthentication()->getAuthService()->hasIdentity()) {
            return $this->redirect()->toRoute($this->moduleOptions->getAuthenticationCallbackRoute());
        }

        $viewModel = new ViewModel([
            'identityNotFound' => null,
            'form'             => $this->recoverPasswordForm,
        ]);

        // Pass in the route/url you want to redirect to after the POST
        $prg = $this->prg($this->url()->fromRoute('zfbuser/recover-password'), true);
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

        $this->recoverPasswordForm->setData($prg);
        if (!$this->recoverPasswordForm->isValid()) {
            return $viewModel;
        }

        $data = $this->recoverPasswordForm->getData();

        $identity = $data[ $this->moduleOptions->getRecoverPasswordFormOptions()->getIdentityFieldName() ];
        $user = $this->userService->getAuthAdapter()->getRepository()->getUserByIdentity($identity);
        if (!$user) {
            $viewModel->setVariable('identityNotFound', true);

            return $viewModel;
        }

        $this->userService->sendRecoveryPasswordCode($user);

        // redirect to confirmation page
        $query = http_build_query(['identity' => $identity]);

        return $this->redirect()->toRoute('zfbuser/recover-password', ['action' => 'sent'], ['query' => $query]);
    }

    /**
     * @return \Zend\Http\Response|\Zend\View\Model\ViewModel
     */
    public function sentAction()
    {
        $identity = $this->params()->fromQuery('identity', null);
        if (empty($identity)) {
            return $this->redirect()->toRoute('zfbuser/authentication');
        }

        $viewModel = new ViewModel([
            'identity' => $identity,
        ]);

        return $viewModel;
    }

    /**
     * @return \Zend\Http\Response|\Zend\View\Model\ViewModel
     */
    public function changeAction()
    {
        /** @var \Zend\Http\PhpEnvironment\Request $request */
        $request = $this->getRequest();

        $viewModel = new ViewModel([
            'identity'   => null,
            'authResult' => null,
            'form'       => $this->changePasswordForm,
        ]);

        if (!$request->isPost()) {
            $identity = $this->params()->fromQuery('identity', null);
            $code = $this->params()->fromQuery('code', null);
            if (empty($identity) || empty($code)) {
                return $this->redirect()->toRoute('zfbuser/authentication');
            }

            $this->changePasswordForm->get('identity')->setValue($identity);
            $this->changePasswordForm->get('code')->setValue($code);
            $viewModel->setVariable('identity', $identity);

            return $viewModel;
        } else {
            $this->changePasswordForm->setData($request->getPost());
            if (!$this->changePasswordForm->isValid()) {
                return $viewModel;
            }

            $data = $this->changePasswordForm->getData();
            $credentialFieldName = $this->moduleOptions->getChangePasswordFormOptions()->getCredentialFieldName();
            $newPassword = $data[ $credentialFieldName ];
            $identity = $data['identity'];
            $code = $data['code'];

            $result = $this->userService->resetPassword($identity, $code, $newPassword);

            if (!$result->isValid()) {
                if ($result->getCode() == AuthenticationResult::FAILURE_IDENTITY_NOT_CONFIRMED) {
                    $query = http_build_query(['identity' => $identity]);

                    return $this->redirect()->toRoute('zfbuser/confirmation', ['action' => 'index'],
                        ['query' => $query]);
                }

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
}
