<?php

namespace ZfbUser\Form;

use Zend\Captcha\ReCaptcha;
use Zend\Form\Element;
use Zend\Form\Form;
use Zend\InputFilter\InputFilter;
use ZfbUser\Options\ReCaptchaOptionsInterface;
use ZfbUser\Options\NewUserFormOptionsInterface;

/**
 * Class NewUserForm
 *
 * @package ZfbUser\Form
 */
class NewUserForm extends Form
{
    /**
     * @var NewUserFormOptionsInterface
     */
    protected $formOptions;

    /**
     * @var ReCaptchaOptionsInterface
     */
    protected $recaptchaOptions;

    /**
     * NewUserForm constructor.
     *
     * @param \ZfbUser\Options\NewUserFormOptionsInterface $options
     * @param \ZfbUser\Options\ReCaptchaOptionsInterface   $recaptchaOptions
     */
    public function __construct(NewUserFormOptionsInterface $options, ReCaptchaOptionsInterface $recaptchaOptions)
    {
        $this->formOptions = $options;
        $this->recaptchaOptions = $recaptchaOptions;

        parent::__construct($options->getFormName(), []);

        $this->addElements()->addInputFilter();
    }

    /**
     * @return \ZfbUser\Options\NewUserFormOptionsInterface
     */
    public function getFormOptions(): NewUserFormOptionsInterface
    {
        return $this->formOptions;
    }

    /**
     * @return \ZfbUser\Form\NewUserForm
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
     * @return \ZfbUser\Form\NewUserForm
     */
    protected function addInputFilter(): self
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

        return $this;
    }
}
