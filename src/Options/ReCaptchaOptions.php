<?php

namespace ZfbUser\Options;

use Zend\Stdlib\AbstractOptions;

/**
 * Class ReCaptchaOptions
 *
 * @package ZfbUser\Options
 */
class ReCaptchaOptions extends AbstractOptions implements ReCaptchaOptionsInterface
{
    /**
     * @var string
     */
    protected $siteKey;

    /**
     * @var string
     */
    protected $secretKey;

    /**
     * @var string
     */
    protected $theme;

    /**
     * @var string
     */
    protected $size;

    /**
     * @var string
     */
    protected $hl;

    /**
     * @return string
     */
    public function getSiteKey(): string
    {
        return $this->siteKey;
    }

    /**
     * @param string $siteKey
     *
     * @return ReCaptchaOptionsInterface
     */
    public function setSiteKey(string $siteKey): ReCaptchaOptionsInterface
    {
        $this->siteKey = $siteKey;

        return $this;
    }

    /**
     * @return string
     */
    public function getSecretKey(): string
    {
        return $this->secretKey;
    }

    /**
     * @param string $secretKey
     *
     * @return ReCaptchaOptionsInterface
     */
    public function setSecretKey(string $secretKey): ReCaptchaOptionsInterface
    {
        $this->secretKey = $secretKey;

        return $this;
    }

    /**
     * @return string
     */
    public function getTheme(): string
    {
        return $this->theme;
    }

    /**
     * @param string $theme
     *
     * @return ReCaptchaOptionsInterface
     */
    public function setTheme(string $theme): ReCaptchaOptionsInterface
    {
        $this->theme = $theme;

        return $this;
    }

    /**
     * @return string
     */
    public function getSize(): string
    {
        return $this->size;
    }

    /**
     * @param string $size
     *
     * @return ReCaptchaOptionsInterface
     */
    public function setSize(string $size): ReCaptchaOptionsInterface
    {
        $this->size = $size;

        return $this;
    }

    /**
     * @return string
     */
    public function getHl(): string
    {
        return $this->hl;
    }

    /**
     * @param string $hl
     *
     * @return ReCaptchaOptionsInterface
     */
    public function setHl(string $hl): ReCaptchaOptionsInterface
    {
        $this->hl = $hl;

        return $this;
    }
}
