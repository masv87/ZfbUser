<?php

namespace ZfbUser\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\View\Model\ViewModel;
use Zend\Form\Form;

/**
 * Class AuthenticationWidget
 *
 * @package ZfbUser\View\Helper
 */
class AuthenticationWidget extends AbstractHelper
{
    /**
     * @var Form
     */
    private $authenticationForm;

    /**
     * Template used for view
     *
     * @var string
     */
    private $viewTemplate = 'zfb-user/user/authentication_widget';

    /**
     * AuthenticationWidget constructor.
     *
     * @param \Zend\Form\Form $authenticationForm
     * @param string          $viewTemplate
     */
    public function __construct(Form $authenticationForm, string $viewTemplate)
    {
        $this->authenticationForm = $authenticationForm;
        $this->viewTemplate = $viewTemplate;
    }

    /**
     * @param array $options
     *
     * @return string|\Zend\View\Model\ViewModel
     */
    public function __invoke(array $options = [])
    {
        if (array_key_exists('render', $options)) {
            $render = $options['render'];
        } else {
            $render = true;
        }
        if (array_key_exists('redirect', $options)) {
            $redirect = $options['redirect'];
        } else {
            $redirect = false;
        }

        $vm = new ViewModel([
            'form'     => $this->authenticationForm,
            'redirect' => $redirect,
        ]);
        $vm->setTemplate($this->viewTemplate);
        if ($render) {
            return $this->getView()->render($vm);
        } else {
            return $vm;
        }
    }
}
