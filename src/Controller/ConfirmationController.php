<?php

namespace ZfbUser\Controller;

use Zend\Http\Response;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use ZfbUser\Options\ModuleOptionsInterface;
use ZfbUser\Service\UserService;

/**
 * Class ConfirmationController
 *
 * @method Plugin\ZfbAuthentication zfbAuthentication()
 * @method Response|array prg(string $redirect = null, bool $redirectToUrl = false)
 *
 * @package ZfbUser\Controller
 */
class ConfirmationController extends AbstractActionController
{
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
     * ConfirmationController constructor.
     *
     * @param \ZfbUser\Service\UserService            $userService
     * @param \ZfbUser\Options\ModuleOptionsInterface $moduleOptions
     */
    public function __construct(UserService $userService, ModuleOptionsInterface $moduleOptions)
    {
        $this->userService = $userService;
        $this->moduleOptions = $moduleOptions;
    }

    /**
     * @return \Zend\Http\Response|\Zend\View\Model\ViewModel
     */
    public function indexAction()
    {
        $identity = $this->params()->fromQuery('identity', null);
        if (empty($identity)) {
            return $this->redirect()->toRoute('zfbuser/authentication');
        }

        $viewModel = new ViewModel([
            'identity' => rawurldecode($identity),
        ]);

        return $viewModel;
    }

    /**
     * @return \Zend\Http\Response|\Zend\View\Model\ViewModel
     * @throws \ZfbUser\Service\Exception\MailTemplateNotFoundException
     * @throws \ZfbUser\Service\Exception\UnsupportedTokenTypeException
     */
    public function resendAction()
    {
        $identity = $this->params()->fromQuery('identity', null);
        $user = $this->userService->getAuthAdapter()->getRepository()->getUserByIdentity($identity);
        if ($user === null || $user->isIdentityConfirmed() === true) {
            return $this->redirect()->toRoute('zfbuser/authentication');
        }

        $this->userService->sendConfirmationCode($user);

        $viewModel = new ViewModel([
            'identity' => $identity,
        ]);

        return $viewModel;
    }

    /**
     * @return \Zend\Http\Response|\Zend\View\Model\ViewModel
     */
    public function confirmAction()
    {
        $identity = $this->params()->fromQuery('identity', null);
        $code = $this->params()->fromQuery('code', null);

        if (empty($identity) || empty($code)) {
            return $this->redirect()->toRoute('zfbuser/authentication');
        }

        if (!$this->moduleOptions->isEnableIdentityConfirmation()) {
            return $this->redirect()->toRoute('zfbuser/authentication');
        }

        $authResult = $this->userService->confirmIdentity($identity, $code);
        if (!$authResult->isValid()) {
            return new ViewModel([
                'identity'   => $identity,
                'authResult' => $authResult,
            ]);
        }

        $query = http_build_query([
            'identity'  => $identity,
            'confirmed' => 1,
        ]);

        return $this->redirect()->toRoute('zfbuser/authentication', [], ['query' => $query]);
    }
}
