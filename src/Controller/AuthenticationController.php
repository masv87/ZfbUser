<?php

namespace ZfbUser\Controller;

use Zend\Http\PhpEnvironment\Request;
use Zend\Http\PhpEnvironment\Response;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;
use ZfbUser\Adapter\AdapterInterface;
use ZfbUser\AuthenticationResult;
use ZfbUser\Form\AuthenticationForm;
use ZfbUser\Options\ModuleOptionsInterface;

/**
 * Class AuthenticationController
 *
 * @method Plugin\ZfbAuthentication zfbAuthentication()
 * @method \Zend\Http\Response|array prg(string $redirect = null, bool $redirectToUrl = false)
 *
 * @package ZfbUser\Controller
 */
class AuthenticationController extends AbstractActionController
{
    /**
     * Форма аутентификации
     *
     * @var AuthenticationForm
     */
    private $authenticationForm;

    /**
     * Адаптер аутентификации
     *
     * @var AdapterInterface
     */
    private $authenticationAdapter;

    /**
     * Параметры модуля
     *
     * @var ModuleOptionsInterface
     */
    private $moduleOptions;

    /**
     * AuthenticationController constructor.
     *
     * @param \ZfbUser\Form\AuthenticationForm        $authenticationForm
     * @param \ZfbUser\Adapter\AdapterInterface       $authenticationAdapter
     * @param \ZfbUser\Options\ModuleOptionsInterface $moduleOptions
     */
    public function __construct(
        AuthenticationForm $authenticationForm,
        AdapterInterface $authenticationAdapter,
        ModuleOptionsInterface $moduleOptions
    ) {
        $this->authenticationForm = $authenticationForm;
        $this->authenticationAdapter = $authenticationAdapter;
        $this->moduleOptions = $moduleOptions;
    }

    /**
     * Авторизация
     *
     * @return \Zend\Http\Response|\Zend\View\Model\ViewModel
     */
    public function authenticationAction()
    {
        if ($this->zfbAuthentication()->hasIdentity()) {
            return $this->redirect()->toRoute($this->moduleOptions->getAuthenticationCallbackRoute());
        }

        /** @var \Zend\Http\PhpEnvironment\Request $request */
        $request = $this->getRequest();

        $redirectTo = null;
        if ($this->moduleOptions->isEnableRedirect()) {
            $redirectTo = $this->params()->fromQuery($this->moduleOptions->getRedirectParamName(), null);
        }

        $viewModel = new ViewModel([
            'form'               => $this->authenticationForm,
            'enableRegistration' => $this->moduleOptions->isEnableRegistration(),
            'confirmed'          => false,
            'passwordChanged'    => false,
            'redirectTo'         => $redirectTo,
        ]);

        if (!$request->isPost()) {
            // После подтверждения подставляем email в поле
            $identity = (string)$this->params()->fromQuery('identity', '');
            $confirmed = (bool)$this->params()->fromQuery('confirmed', false);
            $passwordChanged = (bool)$this->params()->fromQuery('passwordChanged', false);
            $identityFieldName = $this->moduleOptions->getAuthenticationFormOptions()->getIdentityFieldName();
            $this->authenticationForm->get($identityFieldName)->setValue($identity);

            $url = $request->getRequestUri();
            $this->authenticationForm->setAttribute('action', $url);

            $viewModel->setVariable('confirmed', $confirmed);
            $viewModel->setVariable('passwordChanged', $passwordChanged);

            return $viewModel;
        }

        $this->authenticationForm->setData($request->getPost());
        if (!$this->authenticationForm->isValid()) {
            return $viewModel;
        }

        $this->zfbAuthentication()->getAuthService()->clearIdentity();

        return $this->forward()->dispatch(self::class, ['action' => 'authenticate']);
    }

    /**
     * @return \Zend\Http\Response|\Zend\View\Model\ViewModel
     */
    public function authenticateAction()
    {
        if ($this->zfbAuthentication()->hasIdentity()) {
            return $this->redirect()->toRoute($this->moduleOptions->getAuthenticationCallbackRoute());
        }

        /** @var \Zend\Http\PhpEnvironment\Request $request */
        $request = $this->getRequest();
        $data = $request->getPost()->toArray();
        if (empty($data)) {
            return $this->redirect()->toRoute('zfbuser', ['action' => 'authentication']);
        }

        $redirectTo = null;
        if ($this->moduleOptions->isEnableRedirect()) {
            $redirectTo = $this->params()->fromQuery($this->moduleOptions->getRedirectParamName(), null);
        }

        $this->authenticationAdapter
            ->setIdentity($data[$this->moduleOptions->getAuthenticationFormOptions()->getIdentityFieldName()])
            ->setCredential($data[$this->moduleOptions->getAuthenticationFormOptions()->getCredentialFieldName()]);

        /** @var AuthenticationResult $authResult */
        $authResult = $this->zfbAuthentication()->getAuthService()->authenticate($this->authenticationAdapter);

        if (!$authResult->isValid()) {
            if ($authResult->getCode() == AuthenticationResult::FAILURE_IDENTITY_NOT_CONFIRMED) {
                $query = http_build_query([
                    'identity'   => $authResult->getIdentity()->getIdentity(),
                    'redirectTo' => $redirectTo,
                ]);

                return $this->redirect()->toRoute('zfbuser/confirmation', ['action' => 'index'],
                    ['query' => $query]);
            }

            $viewModel = new ViewModel([
                'form'               => $this->authenticationForm,
                'enableRegistration' => $this->moduleOptions->isEnableRegistration(),
                'confirmed'          => false,
                'passwordChanged'    => false,
                'authResult'         => $authResult,
                'redirectTo'         => $redirectTo,
            ]);
            $viewModel->setTemplate('zfb-user/authentication/authentication');

            return $viewModel;
        }

        if (!empty($redirectTo)) {
            return $this->redirect()->toUrl($redirectTo);
        }

        return $this->redirect()->toRoute($this->moduleOptions->getAuthenticationCallbackRoute());
    }

    /**
     * @return \Zend\Http\PhpEnvironment\Response|\Zend\View\Model\JsonModel
     */
    public function apiAuthenticationAction()
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

        $jsonModel = new JsonModel([
            'success' => false,
        ]);

        $this->authenticationForm->setData($request->getPost());
        if (!$this->authenticationForm->isValid()) {
            $formErrors = [];

            /** @var \Zend\Form\Element $element */
            foreach ($this->authenticationForm->getElements() as $element) {
                $messages = $this->authenticationForm->getMessages($element->getName());
                if (!empty($messages)) {
                    $formErrors[ $element->getName() ] = $messages;
                }
            }

            $jsonModel->setVariable('formErrors', $formErrors);

            return $jsonModel;
        }

        $this->zfbAuthentication()->getAuthService()->clearIdentity();

        $data = $this->authenticationForm->getData();
        $this->authenticationAdapter
            ->setIdentity($data[ $this->moduleOptions->getAuthenticationFormOptions()->getIdentityFieldName() ])
            ->setCredential($data[ $this->moduleOptions->getAuthenticationFormOptions()->getCredentialFieldName() ]);

        /** @var AuthenticationResult $authResult */
        $authResult = $this->zfbAuthentication()->getAuthService()->authenticate($this->authenticationAdapter);

        if (!$authResult->isValid()) {
            if ($authResult->getCode() == AuthenticationResult::FAILURE_IDENTITY_NOT_CONFIRMED) {
                $query = http_build_query([
                    'identity' => $authResult->getIdentity()->getIdentity(),
                ]);

                $url = $this->url()->fromRoute('zfbuser/confirmation', ['action' => 'index'], ['query' => $query]);

                $jsonModel->setVariable('identity_not_confirmed', true);
                $jsonModel->setVariable('identity_confirmation_url', $url);

                return $jsonModel;
            }

            $jsonModel->setVariable('errors', $authResult->getMessages());

            return $jsonModel;
        }

        $url = $this->url()->fromRoute($this->moduleOptions->getAuthenticationCallbackRoute());

        $jsonModel->setVariable('success', true);
        $jsonModel->setVariable('authentication_callback_url', $url);

        return $jsonModel;
    }
}
