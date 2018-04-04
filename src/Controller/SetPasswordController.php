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
 * Class SetPasswordController
 *
 * @method Plugin\ZfbAuthentication zfbAuthentication()
 * @method Response|array prg(string $redirect = null, bool $redirectToUrl = false)
 * @method FlashMessenger flashMessenger()
 *
 * @package ZfbUser\Controller
 */
class SetPasswordController extends AbstractActionController
{
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
     * SetPasswordController constructor.
     *
     * @param \Zend\Form\Form                         $setPasswordForm
     * @param \ZfbUser\Service\UserService            $userService
     * @param \ZfbUser\Options\ModuleOptionsInterface $moduleOptions
     */
    public function __construct(Form $setPasswordForm, UserService $userService, ModuleOptionsInterface $moduleOptions)
    {
        $this->setPasswordForm = $setPasswordForm;
        $this->userService = $userService;
        $this->moduleOptions = $moduleOptions;
    }

    /**
     * @return \Zend\Http\Response|\Zend\View\Model\ViewModel
     * @throws \ZfbUser\Service\Exception\EventResultException
     */
    public function indexAction()
    {
        if ($this->zfbAuthentication()->hasIdentity()) {
            $this->zfbAuthentication()->getAuthService()->clearIdentity();
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
