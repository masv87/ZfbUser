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
     * @var ResetPasswordFormOptionsInterface
     */
    protected $resetPasswordFormOptions;

    /**
     * @var AuthenticationFormOptionsInterface
     */
    protected $authenticationFormOptions;

    /**
     * @var RegistrationFormOptionsInterface
     */
    protected $registrationFormOptions;

    /**
     * @var ChangePasswordFormOptionsInterface
     */
    protected $changePasswordFormOptions;

    /**
     * @var NewUserFormOptionsInterface
     */
    protected $newUserFormOptions;

    /**
     * @var UpdateUserFormOptionsInterface
     */
    protected $updateUserFormOptions;

    /**
     * @var SetPasswordFormOptionsInterface
     */
    protected $setPasswordFormOptions;

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
    protected $authenticationWidgetViewTpl = 'zfb-user/user/authentication_widget';

    /**
     * @var int
     */
    protected $passwordCost = 14;

    /**
     * @var bool
     */
    protected $enableIdentityConfirmation = false;

    /**
     * @var bool
     */
    protected $enableRedirect = true;

    /**
     * @var string
     */
    protected $redirectParamName = 'redirectTo';

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

        $resetPasswordFormOptions = [];
        if (!empty($options['reset_password_form'])) {
            $resetPasswordFormOptions = $options['reset_password_form'];
            unset($options['reset_password_form']);
        }
        $this->resetPasswordFormOptions = new ResetPasswordFormOptions($resetPasswordFormOptions);

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

        $changePasswordFormOptions = [];
        if (!empty($options['change_password_form'])) {
            $changePasswordFormOptions = $options['change_password_form'];
            unset($options['change_password_form']);
        }
        $this->changePasswordFormOptions = new ChangePasswordFormOptions($changePasswordFormOptions);

        $newUserFormOptions = [];
        if (!empty($options['new_user_form'])) {
            $newUserFormOptions = $options['new_user_form'];
            unset($options['new_user_form']);
        }
        $this->newUserFormOptions = new NewUserFormOptions($newUserFormOptions);

        $updateUserFormOptions = [];
        if (!empty($options['update_user_form'])) {
            $updateUserFormOptions = $options['update_user_form'];
            unset($options['update_user_form']);
        }
        $this->updateUserFormOptions = new UpdateUserFormOptions($updateUserFormOptions);

        $setPasswordFormOptions = [];
        if (!empty($options['set_password_form'])) {
            $setPasswordFormOptions = $options['set_password_form'];
            unset($options['set_password_form']);
        }
        $this->setPasswordFormOptions = new SetPasswordFormOptions($setPasswordFormOptions);

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
     * @return \ZfbUser\Options\ResetPasswordFormOptionsInterface
     */
    public function getResetPasswordFormOptions(): ResetPasswordFormOptionsInterface
    {
        return $this->resetPasswordFormOptions;
    }

    /**
     * @param \ZfbUser\Options\ResetPasswordFormOptionsInterface $resetPasswordFormOptions
     *
     * @return \ZfbUser\Options\ModuleOptions
     */
    public function setResetPasswordFormOptions(ResetPasswordFormOptionsInterface $resetPasswordFormOptions): self
    {
        $this->resetPasswordFormOptions = $resetPasswordFormOptions;

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
    ): ModuleOptions
    {
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
     * @return \ZfbUser\Options\ChangePasswordFormOptionsInterface
     */
    public function getChangePasswordFormOptions(): ChangePasswordFormOptionsInterface
    {
        return $this->changePasswordFormOptions;
    }

    /**
     * @param \ZfbUser\Options\ChangePasswordFormOptionsInterface $changePasswordFormOptions
     *
     * @return ModuleOptions
     */
    public function setChangePasswordFormOptions(ChangePasswordFormOptionsInterface $changePasswordFormOptions): ModuleOptions
    {
        $this->changePasswordFormOptions = $changePasswordFormOptions;

        return $this;
    }

    /**
     * @return \ZfbUser\Options\NewUserFormOptionsInterface
     */
    public function getNewUserFormOptions(): NewUserFormOptionsInterface
    {
        return $this->newUserFormOptions;
    }

    /**
     * @param \ZfbUser\Options\NewUserFormOptionsInterface $newUserFormOptions
     *
     * @return \ZfbUser\Options\ModuleOptions
     */
    public function setNewUserFormOptions(NewUserFormOptionsInterface $newUserFormOptions): ModuleOptions
    {
        $this->newUserFormOptions = $newUserFormOptions;

        return $this;
    }

    /**
     * @return \ZfbUser\Options\UpdateUserFormOptionsInterface
     */
    public function getUpdateUserFormOptions(): UpdateUserFormOptionsInterface
    {
        return $this->updateUserFormOptions;
    }

    /**
     * @param \ZfbUser\Options\UpdateUserFormOptionsInterface $updateUserFormOptions
     *
     * @return ModuleOptions
     */
    public function setUpdateUserFormOptions(UpdateUserFormOptionsInterface $updateUserFormOptions): ModuleOptions
    {
        $this->updateUserFormOptions = $updateUserFormOptions;

        return $this;
    }

    /**
     * @return \ZfbUser\Options\SetPasswordFormOptionsInterface
     */
    public function getSetPasswordFormOptions(): SetPasswordFormOptionsInterface
    {
        return $this->setPasswordFormOptions;
    }

    /**
     * @param \ZfbUser\Options\SetPasswordFormOptionsInterface $setPasswordFormOptions
     *
     * @return ModuleOptions
     */
    public function setSetPasswordFormOptions(SetPasswordFormOptionsInterface $setPasswordFormOptions): ModuleOptions
    {
        $this->setPasswordFormOptions = $setPasswordFormOptions;

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
     * @return bool
     */
    public function isEnableRedirect(): bool
    {
        return $this->enableRedirect;
    }

    /**
     * @param bool $enableRedirect
     *
     * @return ModuleOptions
     */
    public function setEnableRedirect(bool $enableRedirect): ModuleOptions
    {
        $this->enableRedirect = $enableRedirect;

        return $this;
    }

    /**
     * @return string
     */
    public function getRedirectParamName(): string
    {
        return $this->redirectParamName;
    }

    /**
     * @param string $redirectParamName
     *
     * @return ModuleOptions
     */
    public function setRedirectParamName(string $redirectParamName): ModuleOptions
    {
        $this->redirectParamName = $redirectParamName;

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
