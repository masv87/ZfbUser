<?php

namespace ZfbUser\Controller;

use Zend\Form\Form;
use Zend\Http\Response;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Stdlib\Parameters;
use Zend\View\Model\ViewModel;
use ZfbUser\Options\ModuleOptionsInterface;
use ZfbUser\Service\Exception\UserExistsException;
use ZfbUser\Service\UserService;

/**
 * Class RegistrationController
 *
 * @method Plugin\ZfbAuthentication zfbAuthentication()
 * @method Response|array prg(string $redirect = null, bool $redirectToUrl = false)
 *
 * @package ZfbUser\Controller
 */
class RegistrationController extends AbstractActionController
{
    /**
     * @var UserService
     */
    private $userService;

    /**
     * Форма Регистрации
     *
     * @var Form
     */
    private $registrationForm;

    /**
     * Параметры модуля
     *
     * @var ModuleOptionsInterface
     */
    private $moduleOptions;

    /**
     * RegistrationController constructor.
     *
     * @param \ZfbUser\Service\UserService            $userService
     * @param \Zend\Form\Form                         $registrationForm
     * @param \ZfbUser\Options\ModuleOptionsInterface $moduleOptions
     */
    public function __construct(UserService $userService, Form $registrationForm, ModuleOptionsInterface $moduleOptions)
    {
        $this->userService = $userService;
        $this->registrationForm = $registrationForm;
        $this->moduleOptions = $moduleOptions;
    }

    /**
     * @return array|mixed|\Zend\Http\Response|\Zend\View\Model\ViewModel
     * @throws \ReflectionException
     * @throws \ZfbUser\Service\Exception\MailTemplateNotFoundException
     * @throws \ZfbUser\Service\Exception\UnsupportedTokenTypeException
     */
    public function registrationAction()
    {
        if ($this->zfbAuthentication()->getAuthService()->hasIdentity()) {
            return $this->redirect()->toRoute($this->moduleOptions->getAuthenticationCallbackRoute());
        }

        if ($this->moduleOptions->isEnableRegistration() !== true) {
            return $this->redirect()->toRoute($this->moduleOptions->getLogoutCallbackRoute());
        }

        $viewModel = new ViewModel([
            'form'    => $this->registrationForm,
            'error'   => false,
            'message' => null,
        ]);

        /** @var \Zend\Http\PhpEnvironment\Request $request */
        $request = $this->getRequest();
        $url = $request->getRequestUri();
        $this->registrationForm->setAttribute('action', $url);

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

        $this->registrationForm->setData($prg);
        if (!$this->registrationForm->isValid()) {
            return $viewModel;
        }
        $data = $this->registrationForm->getData();

        try {
            $user = $this->userService->register($data);
        } catch (UserExistsException $ex) {
            $viewModel->setVariable('error', true);
            $viewModel->setVariable('message', $ex->getMessage());

            return $viewModel;
        }

        if ($this->moduleOptions->isAuthenticateAfterRegistration()) {
            $identityFieldName = $this->moduleOptions->getRegistrationFormOptions()->getIdentityFieldName();
            $credentialFieldName = $this->moduleOptions->getRegistrationFormOptions()->getCredentialFieldName();
            $parameters[$identityFieldName] = $user->getIdentity();
            $parameters[$credentialFieldName] = $prg[$credentialFieldName];
            $request->setPost(new Parameters($parameters));

            return $this->forward()->dispatch(AuthenticationController::class, ['action' => 'authenticate']);
        } elseif ($this->moduleOptions->isEnableIdentityConfirmation()) {

            // redirect to confirmation page
            $query = http_build_query(['identity' => $user->getIdentity()]);

            return $this->redirect()->toRoute('zfbuser/confirmation', ['action' => 'index'], ['query' => $query]);
        }

        return $this->redirect()->toRoute($this->moduleOptions->getRegistrationCallbackRoute());
    }
}
