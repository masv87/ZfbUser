<?php

namespace ZfbUser;

use Zend\Authentication\AuthenticationService;
use Zend\I18n\View\Helper\Translate;
use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;

return [
    Module::CONFIG_KEY => [
        'module_options'        => [
            //required, используется при формировании ссылки для подтверждения аккаунта
            'base_url'                     => 'http://ads.dev/',

            // required, see \ZfbUser\Entity\UserInterface
            'user_entity_class'            => Entity\User::class,

            // required, see \ZfbUser\Entity\TokenInterface
            'token_entity_class'           => Entity\Token::class,

            // required if logging enabled, see \ZfbUser\Entity\LogInterface
            'log_entity_class'             => Entity\Log::class,

            // required
            'enable_logging'               => true,

            // required, Включить функцию регистрации?
            'enable_registration'          => true,

            // required
            'password_cost'                => 14,

            // required, Включить функцию подтверждения аккаунта
            'enable_identity_confirmation' => true,

            'enable_redirect'                 => true,
            'redirect_param_name'             => 'redirectTo',

            // required, куда перенаправлять после акторизации
            'authentication_callback_route'   => 'zfbuser',

            // required if "enable_identity_confirmation" is false
            'registration_callback_route'     => 'zfbuser/confirmation',

            // required, куда перенаправлять после выхода
            'logout_callback_route'           => 'zfbuser/authentication',

            //required, должен быть выключен enable_identity_confirmation
            'authenticate_after_registration' => false,

            // required, соль для хеширования паролей
            'crypt_salt'                      => '',

            //required, template for AuthenticationWidget view helper
            'authentication_widget_view_tpl'  => 'zfb-user/index/authentication_widget',

            // required, use for session storage
            'storage_ttl'                     => 60 * 60 * 24, // 7 days
        ],
        'recover_password_form' => [
            'form_name'            => 'recoverPasswordForm',
            'identity_field_label' => 'E-mail',
            'identity_field_name'  => 'identity',
            'submit_button_text'   => 'Submit',
            'csrf_timeout'         => 60 * 1,

            // required, включить капчу?
            'enabled_recaptcha'    => true,
        ],
        'reset_password_form'   => [
            'form_name'                     => 'resetPasswordForm',
            'credential_field_label'        => 'Password',
            'credential_field_name'         => 'credential',
            'credential_verify_field_label' => 'Password Verify',
            'credential_verify_field_name'  => 'credential_verify',
            'submit_button_text'            => 'Submit',
            'csrf_timeout'                  => 60 * 1,

            // required, включить капчу?
            'enabled_recaptcha'             => false,
        ],
        'authentication_form'   => [
            'form_name'              => 'authenticationForm',
            'identity_field_label'   => 'E-mail',
            'identity_field_name'    => 'identity',
            'credential_field_label' => 'Password',
            'credential_field_name'  => 'credential',
            'submit_button_text'     => 'Sign in',
            'csrf_timeout'           => 60 * 3,

            // required, включить капчу?
            'enabled_recaptcha'      => false,
        ],
        'registration_form'     => [
            'form_name'                     => 'registrationForm',
            'credential_verify_field_label' => 'Password Verify',
            'credential_verify_field_name'  => 'credential_verify',
            'submit_button_text'            => 'Sign up',
            'csrf_timeout'                  => 60 * 5,

            // required, включить капчу?
            'enabled_recaptcha'             => false,
        ],
        'change_password_form'  => [
            'form_name'                     => 'changePasswordForm',
            'credential_old_field_label'    => 'Old password',
            'credential_old_field_name'     => 'credential_old',
            'credential_field_label'        => 'Password',
            'credential_field_name'         => 'credential',
            'credential_verify_field_label' => 'Password Verify',
            'credential_verify_field_name'  => 'credential_verify',
            'submit_button_text'            => 'Submit',
            'csrf_timeout'                  => 60 * 3,

            // required, включить капчу?
            'enabled_recaptcha'             => false,
        ],
        'new_user_form'         => [
            'form_name'            => 'addUserForm',
            'identity_field_label' => 'E-mail',
            'identity_field_name'  => 'identity',
            'submit_button_text'   => 'Save',
            'csrf_timeout'         => 60 * 5,

            // required, включить капчу?
            'enabled_recaptcha'    => false,
        ],
        'update_user_form'      => [
            'form_name'            => 'updateUserForm',
            'identity_field_label' => 'E-mail',
            'identity_field_name'  => 'identity',
            'submit_button_text'   => 'Update',
            'csrf_timeout'         => 60 * 5,

            // required, включить капчу?
            'enabled_recaptcha'    => false,
        ],
        'set_password_form'     => [
            'form_name'                     => 'setPasswordForm',
            'identity_field_label'          => 'E-mail',
            'identity_field_name'           => 'identity',
            'credential_field_label'        => 'Password',
            'credential_field_name'         => 'credential',
            'credential_verify_field_label' => 'Password Verify',
            'credential_verify_field_name'  => 'credential_verify',
            'submit_button_text'            => 'Submit',
            'csrf_timeout'                  => 60 * 3,

            // required, включить капчу?
            'enabled_recaptcha'             => false,
        ],
        'mail_sender'           => [
            'from_email'        => 'noreply@example.com',
            'from_name'         => 'Site name',
            'template_path'     => __DIR__ . '/../templates/',
            'transport_factory' => 'zfbuser_mail_sender_file_transport', // or "zfbuser_mail_sender_smtp_transport"
        ],
        // required if enabled, see https://developers.google.com/recaptcha/docs/display
        'recaptcha'             => [
            'site_key'   => '',
            'secret_key' => '',
            'theme'      => 'dark',
            'size'       => 'normal',
            'hl'         => 'en',
        ],
    ],

    'router'             => [
        'routes' => [
            'zfbuser' => [
                'type'          => Literal::class,
                'priority'      => 1000,
                'options'       => [
                    'route'    => '/user',
                    'defaults' => [
                        'controller' => Controller\UserController::class,
                        'action'     => 'index',
                    ],
                ],
                'may_terminate' => true,
                'child_routes'  => [
                    'api'              => [
                        'type'          => Literal::class,
                        'priority'      => 1000,
                        'options'       => [
                            'route'    => '/api',
                            'defaults' => [
                                'controller' => Controller\UserController::class,
                                'action'     => 'apiIndex',
                            ],
                        ],
                        'may_terminate' => true,
                        'child_routes'  => [
                            'get'            => [
                                'type'    => Segment::class,
                                'options' => [
                                    'route'    => '/get/:id',
                                    'defaults' => [
                                        'controller' => Controller\UserController::class,
                                        'action'     => 'apiGet',
                                    ],
                                ],
                            ],
                            'delete'         => [
                                'type'    => Segment::class,
                                'options' => [
                                    'route'    => '/delete/:id',
                                    'defaults' => [
                                        'controller' => Controller\UserController::class,
                                        'action'     => 'apiDelete',
                                    ],
                                ],
                            ],
                            'authentication' => [
                                'type'    => Literal::class,
                                'options' => [
                                    'route'    => '/authentication',
                                    'defaults' => [
                                        'controller' => Controller\AuthenticationController::class,
                                        'action'     => 'apiAuthentication',
                                    ],
                                ],
                            ],
                            'logout'         => [
                                'type'    => Literal::class,
                                'options' => [
                                    'route'    => '/logout',
                                    'defaults' => [
                                        'controller' => Controller\LogoutController::class,
                                        'action'     => 'apiLogout',
                                    ],
                                ],
                            ],
                            'new-user'       => [
                                'type'    => Segment::class,
                                'options' => [
                                    'route'    => '/new-user',
                                    'defaults' => [
                                        'controller' => Controller\NewUserController::class,
                                        'action'     => 'apiIndex',
                                    ],
                                ],
                            ],
                            'update-user'    => [
                                'type'    => Segment::class,
                                'options' => [
                                    'route'    => '/update-user/:id',
                                    'defaults' => [
                                        'controller' => Controller\UpdateUserController::class,
                                        'action'     => 'apiIndex',
                                    ],
                                ],
                            ],
                        ],
                    ],
                    'authentication'   => [
                        'type'    => Literal::class,
                        'options' => [
                            'route'    => '/authentication',
                            'defaults' => [
                                'controller' => Controller\AuthenticationController::class,
                                'action'     => 'authentication',
                            ],
                        ],
                    ],
                    'authenticate'     => [
                        'type'    => Literal::class,
                        'options' => [
                            'route'    => '/authenticate',
                            'defaults' => [
                                'controller' => Controller\AuthenticationController::class,
                                'action'     => 'authenticate',
                            ],
                        ],
                    ],
                    'logout'           => [
                        'type'    => Literal::class,
                        'options' => [
                            'route'    => '/logout',
                            'defaults' => [
                                'controller' => Controller\LogoutController::class,
                                'action'     => 'logout',
                            ],
                        ],
                    ],
                    'registration'     => [
                        'type'    => Literal::class,
                        'options' => [
                            'route'    => '/registration',
                            'defaults' => [
                                'controller' => Controller\RegistrationController::class,
                                'action'     => 'registration',
                            ],
                        ],
                    ],
                    'confirmation'     => [
                        'type'    => Segment::class,
                        'options' => [
                            'route'    => '/confirmation[/:action]',
                            'defaults' => [
                                'controller' => Controller\ConfirmationController::class,
                                'action'     => 'index',
                            ],
                        ],
                    ],
                    'recover-password' => [
                        'type'    => Segment::class,
                        'options' => [
                            'route'    => '/recover-password[/:action]',
                            'defaults' => [
                                'controller' => Controller\RecoverPasswordController::class,
                                'action'     => 'index',
                            ],
                        ],
                    ],
                    'change-password'  => [
                        'type'    => Segment::class,
                        'options' => [
                            'route'    => '/change-password[/:action]',
                            'defaults' => [
                                'controller' => Controller\ChangePasswordController::class,
                                'action'     => 'index',
                            ],
                        ],
                    ],
                    'new-user'         => [
                        'type'    => Segment::class,
                        'options' => [
                            'route'    => '/new-user',
                            'defaults' => [
                                'controller' => Controller\NewUserController::class,
                                'action'     => 'index',
                            ],
                        ],
                    ],
                    'update-user'      => [
                        'type'    => Segment::class,
                        'options' => [
                            'route'    => '/update-user/:id',
                            'defaults' => [
                                'controller' => Controller\UpdateUserController::class,
                                'action'     => 'index',
                            ],
                        ],
                    ],
                    'set-password'     => [
                        'type'    => Segment::class,
                        'options' => [
                            'route'    => '/set-password[/:action]',
                            'defaults' => [
                                'controller' => Controller\SetPasswordController::class,
                                'action'     => 'index',
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
    'view_manager'       => [
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
        'strategies'          => [
            'ViewJsonStrategy',
        ],
    ],
    'controllers'        => [
        'factories' => [
            Controller\UserController::class            => Controller\Factory\UserControllerFactory::class,
            Controller\AuthenticationController::class  => Controller\Factory\AuthenticationControllerFactory::class,
            Controller\RegistrationController::class    => Controller\Factory\RegistrationControllerFactory::class,
            Controller\LogoutController::class          => Controller\Factory\LogoutControllerFactory::class,
            Controller\ConfirmationController::class    => Controller\Factory\ConfirmationControllerFactory::class,
            Controller\RecoverPasswordController::class => Controller\Factory\RecoverPasswordControllerFactory::class,
            Controller\ChangePasswordController::class  => Controller\Factory\ChangePasswordControllerFactory::class,
            Controller\NewUserController::class         => Controller\Factory\NewUserControllerFactory::class,
            Controller\UpdateUserController::class      => Controller\Factory\UpdateUserControllerFactory::class,
            Controller\SetPasswordController::class     => Controller\Factory\SetPasswordControllerFactory::class,
        ],
    ],
    // We register module-provided controller plugins under this key.
    'controller_plugins' => [
        'factories' => [
            Controller\Plugin\ZfbAuthentication::class => Controller\Plugin\Factory\ZfbAuthenticationFactory::class,
        ],
        'aliases'   => [
            'zfbAuthentication' => Controller\Plugin\ZfbAuthentication::class,
        ],
    ],
    'service_manager'    => [
        'factories' => [
            AuthenticationService::class => Service\Factory\AuthenticationServiceFactory::class,
            Options\ModuleOptions::class => Options\Factory\ModuleOptionsFactory::class,
            Service\MailSender::class    => Service\Factory\MailSenderFactory::class,
            Service\UserService::class   => Service\Factory\UserServiceFactory::class,
            Service\TokenService::class  => Service\Factory\TokenServiceFactory::class,
            Service\LogService::class    => Service\Factory\LogServiceFactory::class,

            EventListener\AuthenticationServiceListener::class => EventListener\Factory\AuthenticationServiceListenerFactory::class,

            //changeable services
            'zfbuser_authentication_adapter'                   => Adapter\Factory\DbAdapterFactory::class,
            'zfbuser_user_mapper'                              => Mapper\Factory\UserDoctrineMapperFactory::class,
            'zfbuser_user_repository'                          => Repository\Factory\UserRepositoryFactory::class,
            'zfbuser_token_mapper'                             => Mapper\Factory\TokenDoctrineMapperFactory::class,
            'zfbuser_token_repository'                         => Repository\Factory\TokenRepositoryFactory::class,
            'zfbuser_log_mapper'                               => Mapper\Factory\LogDoctrineMapperFactory::class,
            'zfbuser_log_repository'                           => Repository\Factory\LogRepositoryFactory::class,
            'zfbuser_recover_password_form'                    => Form\Factory\RecoverPasswordFormFactory::class,
            'zfbuser_reset_password_form'                      => Form\Factory\ResetPasswordFormFactory::class,
            'zfbuser_authentication_form'                      => Form\Factory\AuthenticationFormFactory::class,
            'zfbuser_registration_form'                        => Form\Factory\RegistrationFormFactory::class,
            'zfbuser_change_password_form'                     => Form\Factory\ChangePasswordFormFactory::class,
            'zfbuser_new_user_form'                            => Form\Factory\NewUserFormFactory::class,
            'zfbuser_update_user_form'                         => Form\Factory\UpdateUserFormFactory::class,
            'zfbuser_set_password_form'                        => Form\Factory\SetPasswordFormFactory::class,
            'zfbuser_mail_sender_transport'                    => Service\Factory\MailSenderTransportFactory::class,
            'zfbuser_mail_sender_file_transport'               => Service\Factory\MailSenderFileTransportFactory::class,
            'zfbuser_mail_sender_smtp_transport'               => Service\Factory\MailSenderSmtpTransportFactory::class,
        ],
    ],
    'view_helpers'       => [
        'invokables' => [
            'translate' => Translate::class,
        ],
        'factories'  => [
            View\Helper\AuthenticationWidget::class => View\Helper\Factory\AuthenticationWidgetFactory::class,
            View\Helper\UserDisplayName::class      => View\Helper\Factory\UserDisplayNameFactory::class,
            View\Helper\UserIdentity::class         => View\Helper\Factory\UserIdentityFactory::class,
        ],
        'aliases'    => [
            'zfbAuthenticationWidget' => View\Helper\AuthenticationWidget::class,
            'zfbUserDisplayName'      => View\Helper\UserDisplayName::class,
            'zfbUserIdentity'         => View\Helper\UserIdentity::class,
        ],
    ],

    'translator' => [
        'translation_file_patterns' => [
            [
                'type'     => 'phpArray',
                'base_dir' => __DIR__ . '/../language',
                'pattern'  => '%s.php',
            ],
        ],
    ],

    /*'doctrine' => [
        'driver' => [
            __NAMESPACE__ . '_driver' => [
                'class' => AnnotationDriver::class,
                'cache' => 'array',
                'paths' => [__DIR__ . '/../src/Entity'],
            ],
            'orm_default'             => [
                'drivers' => [
                    __NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver',
                ],
            ],
        ],
    ],*/
];
