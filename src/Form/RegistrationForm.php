<?php

namespace ZfbUser\Form;

use Zend\Captcha\ReCaptcha;
use Zend\Filter;
use Zend\Form\Element;
use Zend\Form\Form;
use Zend\InputFilter\InputFilter;
use Zend\Validator;
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
            'type'       => Element\Email::class,
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
            'type'       => Element\Password::class,
            'name'       => $this->getFormOptions()->getCredentialFieldName(),
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
            'type'       => Element\Password::class,
            'name'       => $this->getFormOptions()->getCredentialVerifyFieldName(),
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
                'type'    => Element\Captcha::class,
                'name'    => 'captcha',
                'options' => [
                    'captcha' => $reCaptcha,
                ],
            ]);
        }

        $submitElement = new Element\Button('submit');
        $submitElement
            ->setLabel($this->getFormOptions()->getSubmitButtonText())
            ->setAttributes([
                'type'  => Element\Submit::class,
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
            'filters'    => [
                [
                    'name' => Filter\StripTags::class,
                ],
                [
                    'name' => Filter\StripNewlines::class,
                ],
                [
                    'name' => Filter\StringTrim::class,
                ],
                [
                    'name' => Filter\ToNull::class,
                ],
            ],
            'validators' => [
                [
                    'name' => Validator\EmailAddress::class,
                ],
            ],
        ]);

        $inputFilter->add([
            'name'       => $this->getFormOptions()->getCredentialFieldName(),
            'required'   => true,
            'filters'    => [
                [
                    'name' => Filter\StripTags::class,
                ],
                [
                    'name' => Filter\StripNewlines::class,
                ],
                [
                    'name' => Filter\StringTrim::class,
                ],
                [
                    'name' => Filter\ToNull::class,
                ],
            ],
            'validators' => [
                [
                    'name'    => Validator\StringLength::class,
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
            'filters'    => [
                [
                    'name' => Filter\StripTags::class,
                ],
                [
                    'name' => Filter\StripNewlines::class,
                ],
                [
                    'name' => Filter\StringTrim::class,
                ],
                [
                    'name' => Filter\ToNull::class,
                ],
            ],
            'validators' => [
                [
                    'name'    => Validator\Identical::class,
                    'options' => [
                        'token' => $this->getFormOptions()->getCredentialFieldName(),
                    ],
                ],
            ],
        ]);

        return $this;
    }
}
