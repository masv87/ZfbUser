<?php

namespace ZfbUser\Options;

/**
 * Interface ModuleOptionsInterface
 *
 * @package ZfbUser\Options
 */
interface ModuleOptionsInterface extends OptionsInterface
{
    /**
     * @return string
     */
    public function getCurrentLocale(): string;

    /**
     * @return \ZfbUser\Options\RecoverPasswordFormOptionsInterface
     */
    public function getRecoverPasswordFormOptions(): RecoverPasswordFormOptionsInterface;

    /**
     * @return \ZfbUser\Options\ResetPasswordFormOptionsInterface
     */
    public function getResetPasswordFormOptions(): ResetPasswordFormOptionsInterface;

    /**
     * @return AuthenticationFormOptionsInterface
     */
    public function getAuthenticationFormOptions(): AuthenticationFormOptionsInterface;

    /**
     * @return RegistrationFormOptionsInterface
     */
    public function getRegistrationFormOptions(): RegistrationFormOptionsInterface;

    /**
     * @return MailSenderOptionsInterface
     */
    public function getMailSenderOptions(): MailSenderOptionsInterface;

    /**
     * @return \ZfbUser\Options\ReCaptchaOptionsInterface
     */
    public function getRecaptchaOptions(): ReCaptchaOptionsInterface;

    /**
     * @return string
     */
    public function getBaseUrl(): string;

    /**
     * @return string
     */
    public function getUserEntityClass(): string;

    /**
     * @return string
     */
    public function getTokenEntityClass(): string;

    /**
     * @return boolean
     */
    public function isEnableRegistration(): bool;

    /**
     * @return int
     */
    public function getStorageTtl(): int;

    /**
     * @return string
     */
    public function getAuthenticationWidgetViewTpl(): string;

    /**
     * @return int
     */
    public function getPasswordCost(): int;

    /**
     * @return bool
     */
    public function isEnableIdentityConfirmation(): bool;

    /**
     * @return string
     */
    public function getAuthenticationCallbackRoute(): string;

    /**
     * @return string
     */
    public function getRegistrationCallbackRoute(): string;

    /**
     * @return string
     */
    public function getLogoutCallbackRoute();

    /**
     * @return bool
     */
    public function isAuthenticateAfterRegistration(): bool;

    /**
     * @return string
     */
    public function getCryptSalt(): string;
}
