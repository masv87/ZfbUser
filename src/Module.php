<?php

namespace ZfbUser;

use Zend\Mvc\MvcEvent;
use Zend\Validator\AbstractValidator;
use Zend\Authentication\AuthenticationService;
use Zend\EventManager\LazyListenerAggregate;
use ZfbUser\EventListener\AuthenticationServiceListener;
use ZfbUser\Service\Event\AuthenticateEvent;
use ZfbUser\Service\Event\LogoutEvent;

/**
 * Class Module
 *
 * @package ZfbUser
 */
class Module
{
    const VERSION = '1.0';

    const CONFIG_KEY = 'zfb_user';

    /**
     * @param \Zend\Mvc\MvcEvent $e
     *
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function onBootstrap(MvcEvent $e)
    {
        AbstractValidator::setDefaultTranslator($e->getApplication()->getServiceManager()->get('MvcTranslator'));

        /**
         * TODO:
         * 1. подписаться на события authServic'a
         * 2. Залогировать в бд через logService.
         */

        $app = $e->getApplication();
        $app->getEventManager()->attach(MvcEvent::EVENT_DISPATCH, function (MvcEvent $e) use ($app) {

            $authenticationService = $app->getServiceManager()->get(AuthenticationService::class);
            $aggregate = new LazyListenerAggregate(
                [
                    [
                        'listener' => AuthenticationServiceListener::class,
                        'method'   => 'onAuthenticatePre',
                        'event'    => AuthenticateEvent::EVENT_PRE,
                        'priority' => 100,
                    ],
                    [
                        'listener' => AuthenticationServiceListener::class,
                        'method'   => 'onAuthenticatePost',
                        'event'    => AuthenticateEvent::EVENT_POST,
                        'priority' => 100,
                    ],
                    [
                        'listener' => AuthenticationServiceListener::class,
                        'method'   => 'onAuthenticateError',
                        'event'    => AuthenticateEvent::EVENT_ERROR,
                        'priority' => 100,
                    ],
                    [
                        'listener' => AuthenticationServiceListener::class,
                        'method'   => 'onLogoutPre',
                        'event'    => LogoutEvent::EVENT_PRE,
                        'priority' => 100,
                    ],
                ],
                $app->getServiceManager()
            );
            $aggregate->attach($authenticationService->getEventManager());

            return true;
        }, 10);
    }

    /**
     * @return array
     */
    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }
}
