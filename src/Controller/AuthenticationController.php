<?php

namespace ZfbUser\Controller;

use Zend\Http\Response;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use ZfbUser\Adapter\AdapterInterface;
use ZfbUser\AuthenticationResult;
use ZfbUser\Form\AuthenticationForm;
use ZfbUser\Options\ModuleOptionsInterface;

/**
 * Class AuthenticationController
 *
 * @method Plugin\ZfbAuthentication zfbAuthentication()
 * @method Response|array prg(string $redirect = null, bool $redirectToUrl = false)
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

        $viewModel = new ViewModel([
            'form'               => $this->authenticationForm,
            'enableRegistration' => $this->moduleOptions->isEnableRegistration(),
            'confirmed'          => false,
            'passwordChanged'    => false,
        ]);

        if (!$request->isPost()) {
            // После подтверждения подставляем email в поле
            $identity = (string)$this->params()->fromQuery('identity', '');
            $confirmed = (bool)$this->params()->fromQuery('confirmed', false);
            $passwordChanged = (bool)$this->params()->fromQuery('passwordChanged', false);
            $identityFieldName = $this->moduleOptions->getAuthenticationFormOptions()->getIdentityFieldName();
            $this->authenticationForm->get($identityFieldName)->setValue($identity);

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

                return $this->redirect()->toRoute('zfbuser/confirmation', ['action' => 'index'],
                    ['query' => $query]);
            }

            $vewModel = new ViewModel([
                'form'               => $this->authenticationForm,
                'enableRegistration' => $this->moduleOptions->isEnableRegistration(),
                'confirmed'          => false,
                'passwordChanged'    => false,
                'authResult'         => $authResult,
            ]);
            $vewModel->setTemplate('zfb-user/authentication/authentication');

            return $vewModel;
        }

        return $this->redirect()->toRoute($this->moduleOptions->getAuthenticationCallbackRoute());
    }
}
