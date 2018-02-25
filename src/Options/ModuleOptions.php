<?php

namespace ZfbUser\Options;

use Zend\Stdlib\AbstractOptions;
use ZfbUser\Entity\User as UserEntity;
use ZfbUser\Entity\Token as TokenEntity;

/**
 * Class ModuleOptions
 *
 * @package ZfbUser\Options
 */
class ModuleOptions extends AbstractOptions implements ModuleOptionsInterface
{
    /**
     * @var string
     */
    protected $currentLocale;

    /**
     * @var RecoverPasswordFormOptionsInterface
     */
    protected $recoverPasswordFormOptions;

    /**
     * @var ChangePasswordFormOptionsInterface
     */
    protected $changePasswordFormOptions;

    /**
     * @var AuthenticationFormOptionsInterface
     */
    protected $authenticationFormOptions;

    /**
     * @var RegistrationFormOptionsInterface
     */
    protected $registrationFormOptions;

    /**
     * @var MailSenderOptionsInterface
     */
    protected $mailSenderOptions;

    /**
     * @var ReCaptchaOptionsInterface
     */
    protected $recaptchaOptions;

    /**
     * @var string
     */
    protected $baseUrl;

    /**
     * @var string
     */
    protected $userEntityClass = UserEntity::class;

    /**
     * @var string
     */
    protected $tokenEntityClass = TokenEntity::class;

    /**
     * @var bool
     */
    protected $enableRegistration = true;

    /**
     * @var int
     */
    protected $storageTtl = 60 * 60 * 24; // 7 days

    /**
     * @var string
     */
    protected $authenticationWidgetViewTpl = 'zfb-user/index/authentication_widget';

    /**
     * @var int
     */
    protected $passwordCost = 14;

    /**
     * @var bool
     */
    protected $enableIdentityConfirmation = false;

    /**
     * @var string
     */
    protected $authenticationCallbackRoute = 'zfbuser';

    /**
     * @var string
     */
    protected $registrationCallbackRoute = 'zfbuser';

    /**
     * @var string
     */
    protected $logoutCallbackRoute = 'zfbuser';

    /**
     * @var bool
     */
    protected $authenticateAfterRegistration = true;

    /**
     * @var string
     */
    protected $cryptSalt = '';

    /**
     * ModuleOptions constructor.
     *
     * @param string $currentLocale
     * @param array  $options
     */
    public function __construct(string $currentLocale, array $options = [])
    {
        $this->currentLocale = $currentLocale;

        $recoverPasswordFormOptions = [];
        if (!empty($options['recover_password_form'])) {
            $recoverPasswordFormOptions = $options['recover_password_form'];
            unset($options['recover_password_form']);
        }
        $this->recoverPasswordFormOptions = new RecoverPasswordFormOptions($recoverPasswordFormOptions);

        $changePasswordFormOptions = [];
        if (!empty($options['change_password_form'])) {
            $changePasswordFormOptions = $options['change_password_form'];
            unset($options['change_password_form']);
        }
        $this->changePasswordFormOptions = new ChangePasswordFormOptions($changePasswordFormOptions);

        $authenticationFormOptions = [];
        if (!empty($options['authentication_form'])) {
            $authenticationFormOptions = $options['authentication_form'];
            unset($options['authentication_form']);
        }
        $this->authenticationFormOptions = new AuthenticationFormOptions($authenticationFormOptions);

        $registrationFormOptions = [];
        if (!empty($options['registration_form'])) {
            $registrationFormOptions = array_merge($authenticationFormOptions, $options['registration_form']);
            unset($options['registration_form']);
        }
        $this->registrationFormOptions = new RegistrationFormOptions($registrationFormOptions);

        $mailSenderOptions = [];
        if (!empty($options['mail_sender'])) {
            $mailSenderOptions = $options['mail_sender'];
            unset($options['mail_sender']);
        }
        $this->mailSenderOptions = new MailSenderOptions($mailSenderOptions);

        $recaptchaOptions = [];
        if (!empty($options['recaptcha'])) {
            $recaptchaOptions = $options['recaptcha'];
            unset($options['recaptcha']);
        }
        $this->recaptchaOptions = new ReCaptchaOptions($recaptchaOptions);
        $this->recaptchaOptions->setHl($this->currentLocale);

        parent::__construct($options['module_options']);
    }

    /**
     * @return string
     */
    public function getCurrentLocale(): string
    {
        return $this->currentLocale;
    }

    /**
     * @return \ZfbUser\Options\ChangePasswordFormOptionsInterface
     */
    public function getChangePasswordFormOptions(): ChangePasswordFormOptionsInterface
    {
        return $this->changePasswordFormOptions;
    }

    /**
     * @param \ZfbUser\Options\ChangePasswordFormOptionsInterface $changePasswordFormOptions
     *
     * @return \ZfbUser\Options\ModuleOptions
     */
    public function setChangePasswordFormOptions(ChangePasswordFormOptionsInterface $changePasswordFormOptions): self
    {
        $this->changePasswordFormOptions = $changePasswordFormOptions;

        return $this;
    }

    /**
     * @return \ZfbUser\Options\RecoverPasswordFormOptionsInterface
     */
    public function getRecoverPasswordFormOptions(): RecoverPasswordFormOptionsInterface
    {
        return $this->recoverPasswordFormOptions;
    }

    /**
     * @param \ZfbUser\Options\RecoverPasswordFormOptionsInterface $recoverPasswordFormOptions
     *
     * @return \ZfbUser\Options\ModuleOptions
     */
    public function setRecoverPasswordFormOptions(RecoverPasswordFormOptionsInterface $recoverPasswordFormOptions): self
    {
        $this->recoverPasswordFormOptions = $recoverPasswordFormOptions;

        return $this;
    }

    /**
     * @return \ZfbUser\Options\AuthenticationFormOptionsInterface
     */
    public function getAuthenticationFormOptions(): AuthenticationFormOptionsInterface
    {
        return $this->authenticationFormOptions;
    }

    /**
     * @param \ZfbUser\Options\AuthenticationFormOptionsInterface $authenticationFormOptions
     *
     * @return ModuleOptions
     */
    public function setAuthenticationFormOptions(AuthenticationFormOptionsInterface $authenticationFormOptions
    ): ModuleOptions {
        $this->authenticationFormOptions = $authenticationFormOptions;

        return $this;
    }

    /**
     * @return \ZfbUser\Options\RegistrationFormOptionsInterface
     */
    public function getRegistrationFormOptions(): RegistrationFormOptionsInterface
    {
        return $this->registrationFormOptions;
    }

    /**
     * @param \ZfbUser\Options\RegistrationFormOptionsInterface $registrationFormOptions
     *
     * @return ModuleOptions
     */
    public function setRegistrationFormOptions(RegistrationFormOptionsInterface $registrationFormOptions): ModuleOptions
    {
        $this->registrationFormOptions = $registrationFormOptions;

        return $this;
    }

    /**
     * @return \ZfbUser\Options\MailSenderOptionsInterface
     */
    public function getMailSenderOptions(): MailSenderOptionsInterface
    {
        return $this->mailSenderOptions;
    }

    /**
     * @param \ZfbUser\Options\MailSenderOptionsInterface $mailSenderOptions
     *
     * @return \ZfbUser\Options\ModuleOptions
     */
    public function setMailSenderOptions(MailSenderOptionsInterface $mailSenderOptions): ModuleOptions
    {
        $this->mailSenderOptions = $mailSenderOptions;

        return $this;
    }

    /**
     * @return \ZfbUser\Options\ReCaptchaOptionsInterface
     */
    public function getRecaptchaOptions(): ReCaptchaOptionsInterface
    {
        return $this->recaptchaOptions;
    }

    /**
     * @param \ZfbUser\Options\ReCaptchaOptionsInterface $recaptchaOptions
     *
     * @return \ZfbUser\Options\ModuleOptions
     */
    public function setRecaptchaOptions(ReCaptchaOptionsInterface $recaptchaOptions): ModuleOptions
    {
        $this->recaptchaOptions = $recaptchaOptions;

        return $this;
    }

    /**
     * @return string
     */
    public function getBaseUrl(): string
    {
        return $this->baseUrl;
    }

    /**
     * @param string $baseUrl
     *
     * @return ModuleOptions
     */
    public function setBaseUrl(string $baseUrl): ModuleOptions
    {
        $this->baseUrl = $baseUrl;

        return $this;
    }

    /**
     * @return string
     */
    public function getUserEntityClass(): string
    {
        return $this->userEntityClass;
    }

    /**
     * @param string $userEntityClass
     *
     * @return ModuleOptions
     */
    public function setUserEntityClass(string $userEntityClass): ModuleOptions
    {
        $this->userEntityClass = $userEntityClass;

        return $this;
    }

    /**
     * @return string
     */
    public function getTokenEntityClass(): string
    {
        return $this->tokenEntityClass;
    }

    /**
     * @param string $tokenEntityClass
     *
     * @return \ZfbUser\Options\ModuleOptions
     */
    public function setTokenEntityClass(string $tokenEntityClass): ModuleOptions
    {
        $this->tokenEntityClass = $tokenEntityClass;

        return $this;
    }

    /**
     * @return bool
     */
    public function isEnableRegistration(): bool
    {
        return $this->enableRegistration;
    }

    /**
     * @param bool $enableRegistration
     *
     * @return ModuleOptions
     */
    public function setEnableRegistration(bool $enableRegistration): ModuleOptions
    {
        $this->enableRegistration = $enableRegistration;

        return $this;
    }

    /**
     * @return int
     */
    public function getStorageTtl(): int
    {
        return $this->storageTtl;
    }

    /**
     * @param int $storageTtl
     *
     * @return ModuleOptions
     */
    public function setStorageTtl(int $storageTtl): ModuleOptions
    {
        $this->storageTtl = $storageTtl;

        return $this;
    }

    /**
     * @return string
     */
    public function getAuthenticationWidgetViewTpl(): string
    {
        return $this->authenticationWidgetViewTpl;
    }

    /**
     * @param string $authenticationWidgetViewTpl
     *
     * @return ModuleOptions
     */
    public function setAuthenticationWidgetViewTpl(string $authenticationWidgetViewTpl): ModuleOptions
    {
        $this->authenticationWidgetViewTpl = $authenticationWidgetViewTpl;

        return $this;
    }

    /**
     * @return int
     */
    public function getPasswordCost(): int
    {
        return $this->passwordCost;
    }

    /**
     * @param int $passwordCost
     *
     * @return ModuleOptions
     */
    public function setPasswordCost(int $passwordCost): ModuleOptions
    {
        $this->passwordCost = $passwordCost;

        return $this;
    }

    /**
     * @return bool
     */
    public function isEnableIdentityConfirmation(): bool
    {
        return $this->enableIdentityConfirmation;
    }

    /**
     * @param bool $enableIdentityConfirmation
     *
     * @return ModuleOptions
     */
    public function setEnableIdentityConfirmation(bool $enableIdentityConfirmation): ModuleOptions
    {
        $this->enableIdentityConfirmation = $enableIdentityConfirmation;

        return $this;
    }

    /**
     * @return string
     */
    public function getAuthenticationCallbackRoute(): string
    {
        return $this->authenticationCallbackRoute;
    }

    /**
     * @param string $authenticationCallbackRoute
     *
     * @return ModuleOptions
     */
    public function setAuthenticationCallbackRoute(string $authenticationCallbackRoute): ModuleOptions
    {
        $this->authenticationCallbackRoute = $authenticationCallbackRoute;

        return $this;
    }

    /**
     * @return string
     */
    public function getRegistrationCallbackRoute(): string
    {
        return $this->registrationCallbackRoute;
    }

    /**
     * @param string $registrationCallbackRoute
     *
     * @return \ZfbUser\Options\ModuleOptions
     */
    public function setRegistrationCallbackRoute(string $registrationCallbackRoute): ModuleOptions
    {
        $this->registrationCallbackRoute = $registrationCallbackRoute;

        return $this;
    }

    /**
     * @return string
     */
    public function getLogoutCallbackRoute(): string
    {
        return $this->logoutCallbackRoute;
    }

    /**
     * @param string $logoutCallbackRoute
     *
     * @return ModuleOptions
     */
    public function setLogoutCallbackRoute(string $logoutCallbackRoute): ModuleOptions
    {
        $this->logoutCallbackRoute = $logoutCallbackRoute;

        return $this;
    }

    /**
     * @return bool
     */
    public function isAuthenticateAfterRegistration(): bool
    {
        return $this->authenticateAfterRegistration;
    }

    /**
     * @param bool $authenticateAfterRegistration
     *
     * @return ModuleOptions
     */
    public function setAuthenticateAfterRegistration(bool $authenticateAfterRegistration): ModuleOptions
    {
        $this->authenticateAfterRegistration = $authenticateAfterRegistration;

        return $this;
    }

    /**
     * @return string
     */
    public function getCryptSalt(): string
    {
        return $this->cryptSalt;
    }

    /**
     * @param string $cryptSalt
     *
     * @return ModuleOptions
     */
    public function setCryptSalt(string $cryptSalt): ModuleOptions
    {
        $this->cryptSalt = $cryptSalt;

        return $this;
    }
}
