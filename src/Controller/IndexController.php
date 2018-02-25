<?php

namespace ZfbUser\Controller;

use Zend\Http\Response;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use ZfbUser\Options\ModuleOptionsInterface;

/**
 * Class IndexController
 *
 * @method Plugin\ZfbAuthentication zfbAuthentication()
 * @method Response|array prg(string $redirect = null, bool $redirectToUrl = false)
 *
 * @package ZfbUser\Controller
 */
class IndexController extends AbstractActionController
{
    /**
     * Параметры модуля
     *
     * @var ModuleOptionsInterface
     */
    private $moduleOptions;

    /**
     * IndexController constructor.
     *
     * @param \ZfbUser\Options\ModuleOptionsInterface $moduleOptions
     */
    public function __construct(ModuleOptionsInterface $moduleOptions)
    {
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

        $viewModel = new ViewModel([
            'user' => $this->zfbAuthentication()->getIdentity(),
        ]);

        return $viewModel;
    }
}
