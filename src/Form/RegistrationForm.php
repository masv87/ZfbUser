<?php

namespace ZfbUser\Form;

use Zend\Captcha\ReCaptcha;
use Zend\Form\Element;
use Zend\Form\Form;
use Zend\InputFilter\InputFilter;
use ZfbUser\Options\ReCaptchaOptionsInterface;
use ZfbUser\Options\RegistrationFormOptionsInterface;

/**
 * Class RegistrationForm
 *
 * @package ZfbUser\Form
 */
class RegistrationForm extends Form
{
    /**
     * @var RegistrationFormOptionsInterface
     */
    protected $formOptions;

    /**
     * @var ReCaptchaOptionsInterface
     */
    protected $recaptchaOptions;

    /**
     * RegistrationForm constructor.
     *
     * @param \ZfbUser\Options\RegistrationFormOptionsInterface $options
     * @param \ZfbUser\Options\ReCaptchaOptionsInterface        $recaptchaOptions
     */
    public function __construct(RegistrationFormOptionsInterface $options, ReCaptchaOptionsInterface $recaptchaOptions)
    {
        parent::__construct($options->getFormName(), []);

        $this->formOptions = $options;
        $this->recaptchaOptions = $recaptchaOptions;
        $this->addElements()->addInputFilter();
    }

    /**
     * @return RegistrationFormOptionsInterface
     */
    public function getFormOptions()
    {
        return $this->formOptions;
    }

    /**
     * @return \ZfbUser\Form\RegistrationForm
     */
    protected function addElements(): self
    {
        $this->add([
            'name'       => $this->getFormOptions()->getIdentityFieldName(),
            'options'    => [
                'label' => $this->getFormOptions()->getIdentityFieldLabel(),
            ],
            'attributes' => [
                'type'     => 'email',
                'required' => true,
                'class'    => 'identity',
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
     * @return $this
     */
    protected function addInputFilter()
    {
        $inputFilter = new InputFilter();
        $this->setInputFilter($inputFilter);

        $inputFilter->add([
            'name'       => $this->getFormOptions()->getIdentityFieldName(),
            'required'   => true,
            'validators' => [
                [
                    'name' => 'EmailAddress',
                ],
            ],
        ]);

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
