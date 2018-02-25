<?php

namespace ZfbUser\Form;

use Zend\Captcha\ReCaptcha;
use Zend\Form\Element;
use Zend\Form\Form;
use Zend\InputFilter\InputFilter;
use ZfbUser\Options\ChangePasswordFormOptionsInterface;
use ZfbUser\Options\ReCaptchaOptionsInterface;

/**
 * Class ChangePasswordForm
 *
 * @package ZfbUser\Form
 */
class ChangePasswordForm extends Form
{
    /**
     * @var ChangePasswordFormOptionsInterface
     */
    protected $formOptions;

    /**
     * @var ReCaptchaOptionsInterface
     */
    protected $recaptchaOptions;

    /**
     * AuthenticationForm constructor.
     *
     * @param \ZfbUser\Options\ChangePasswordFormOptionsInterface $options
     * @param \ZfbUser\Options\ReCaptchaOptionsInterface          $recaptchaOptions
     */
    public function __construct(
        ChangePasswordFormOptionsInterface $options,
        ReCaptchaOptionsInterface $recaptchaOptions
    ) {
        $this->formOptions = $options;
        $this->recaptchaOptions = $recaptchaOptions;

        parent::__construct($options->getFormName(), []);

        $this->addElements()->addInputFilter();
    }

    /**
     * @return \ZfbUser\Options\ChangePasswordFormOptionsInterface
     */
    public function getFormOptions()
    {
        return $this->formOptions;
    }

    /**
     * @return \ZfbUser\Form\ChangePasswordForm
     */
    protected function addElements(): self
    {
        $this->add([
            'name'       => 'identity',
            'attributes' => [
                'type'     => 'hidden',
                'required' => true,
            ],
        ]);

        $this->add([
            'name'       => 'code',
            'attributes' => [
                'type'     => 'hidden',
                'required' => true,
            ],
        ]);

        $this->add([
            'name'       => $this->getFormOptions()->getCredentialFieldName(),
            'type'       => 'password',
            'options'    => [
                'label' => $this->getFormOptions()->getCredentialFieldLabel(),
            ],
            'attributes' => [
                'type'     => 'password',
                'required' => true,
                'class'    => 'password',
            ],
        ]);

        $this->add([
            'name'       => $this->getFormOptions()->getCredentialVerifyFieldName(),
            'type'       => 'password',
            'options'    => [
                'label' => $this->getFormOptions()->getCredentialVerifyFieldLabel(),
            ],
            'attributes' => [
                'type'     => 'password',
                'required' => true,
                'class'    => 'password password-verify',
            ],
        ]);

        if ($this->formOptions->isEnabledRecaptcha()) {
            $reCaptcha = new ReCaptcha($this->recaptchaOptions->toArray());
            $this->add([
                'name'    => 'captcha',
                'type'    => 'captcha',
                'options' => [
                    'captcha' => $reCaptcha,
                ],
            ]);
        }

        $submitElement = new Element\Button('submit');
        $submitElement
            ->setLabel($this->getFormOptions()->getSubmitButtonText())
            ->setAttributes([
                'type'  => 'submit',
                'class' => 'submit',
            ]);

        $this->add($submitElement, [
            'priority' => -100,
        ]);

        $csrf = new Element\Csrf('csrf');
        $csrf->getCsrfValidator()->setTimeout($this->getFormOptions()->getCsrfTimeout());
        $this->add($csrf);

        return $this;
    }

    /**
     * @return \ZfbUser\Form\ChangePasswordForm
     */
    protected function addInputFilter(): self
    {
        $inputFilter = new InputFilter();
        $this->setInputFilter($inputFilter);

        $inputFilter->add([
            'name'       => $this->getFormOptions()->getCredentialFieldName(),
            'required'   => true,
            'filters'    => [['name' => 'StringTrim']],
            'validators' => [
                [
                    'name'    => 'StringLength',
                    'options' => [
                        'min' => 6,
                        'max' => 18,
                    ],
                ],
            ],
        ]);

        $inputFilter->add([
            'name'       => $this->getFormOptions()->getCredentialVerifyFieldName(),
            'required'   => true,
            'filters'    => [['name' => 'StringTrim']],
            'validators' => [
                [
                    'name'    => 'StringLength',
                    'options' => [
                        'min' => 6,
                        'max' => 18,
                    ],
                ],
                [
                    'name'    => 'Identical',
                    'options' => [
                        'token' => $this->getFormOptions()->getCredentialFieldName(),
                    ],
                ],
            ],
        ]);

        return $this;
    }
}
