<?php

namespace ZfbUser\Form;

use Zend\Captcha\ReCaptcha;
use Zend\Filter;
use Zend\Form\Element;
use Zend\Form\Form;
use Zend\InputFilter\InputFilter;
use Zend\Validator;
use ZfbUser\Options\AuthenticationFormOptionsInterface;
use ZfbUser\Options\ReCaptchaOptionsInterface;

/**
 * Class AuthenticationForm
 *
 * @package ZfbUser\Form
 */
class AuthenticationForm extends Form
{
    /**
     * @var AuthenticationFormOptionsInterface
     */
    protected $formOptions;

    /**
     * @var ReCaptchaOptionsInterface
     */
    protected $recaptchaOptions;

    /**
     * AuthenticationForm constructor.
     *
     * @param \ZfbUser\Options\AuthenticationFormOptionsInterface $options
     * @param \ZfbUser\Options\ReCaptchaOptionsInterface          $recaptchaOptions
     */
    public function __construct(
        AuthenticationFormOptionsInterface $options,
        ReCaptchaOptionsInterface $recaptchaOptions
    ) {
        $this->formOptions = $options;
        $this->recaptchaOptions = $recaptchaOptions;

        parent::__construct($options->getFormName(), []);

        $this->addElements()->addInputFilter();
    }

    /**
     * @return AuthenticationFormOptionsInterface
     */
    public function getFormOptions()
    {
        return $this->formOptions;
    }

    /**
     * @return \ZfbUser\Form\AuthenticationForm
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
                'class'    => 'credential',
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
     * @return \ZfbUser\Form\AuthenticationForm
     */
    protected function addInputFilter(): self
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
            'name'     => $this->getFormOptions()->getCredentialFieldName(),
            'required' => true,
            'filters'  => [
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
        ]);

        return $this;
    }
}
