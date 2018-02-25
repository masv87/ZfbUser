<?php

namespace ZfbUser\Options;

use Zend\Stdlib\AbstractOptions;

/**
 * Class AuthenticationFormOptions
 *
 * @package ZfbUser\Options
 */
class FormOptions extends AbstractOptions implements FormOptionsInterface
{
    /**
     * @var string
     */
    protected $formName = 'form';

    /**
     * @var string
     */
    protected $submitButtonText = 'Go';

    /**
     * @var int
     */
    protected $csrfTimeout = 60 * 5;

    /**
     * @var bool
     */
    protected $enabledRecaptcha = false;

    /**
     * @return string
     */
    public function getFormName(): string
    {
        return $this->formName;
    }

    /**
     * @param string $formName
     *
     * @return FormOptionsInterface
     */
    public function setFormName(string $formName): FormOptionsInterface
    {
        $this->formName = $formName;

        return $this;
    }

    /**
     * @return string
     */
    public function getSubmitButtonText(): string
    {
        return $this->submitButtonText;
    }

    /**
     * @param string $submitButtonText
     *
     * @return FormOptions
     */
    public function setSubmitButtonText(string $submitButtonText): FormOptions
    {
        $this->submitButtonText = $submitButtonText;

        return $this;
    }

    /**
     * @return int
     */
    public function getCsrfTimeout(): int
    {
        return $this->csrfTimeout;
    }

    /**
     * @param int $csrfTimeout
     *
     * @return FormOptions
     */
    public function setCsrfTimeout(int $csrfTimeout): FormOptions
    {
        $this->csrfTimeout = $csrfTimeout;

        return $this;
    }

    /**
     * @return bool
     */
    public function isEnabledRecaptcha(): bool
    {
        return $this->enabledRecaptcha;
    }

    /**
     * @param bool $enabledRecaptcha
     *
     * @return FormOptions
     */
    public function setEnabledRecaptcha(bool $enabledRecaptcha): FormOptions
    {
        $this->enabledRecaptcha = $enabledRecaptcha;

        return $this;
    }
}
