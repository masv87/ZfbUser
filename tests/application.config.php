<?php
return [
    // Retrieve list of modules used in this application.
    'modules' => [
        'Zend\Form',
        'Zend\Serializer',
        'Zend\Mail',
        'Zend\Session',
        'Zend\Hydrator',
        'Zend\InputFilter',
        'Zend\Filter',
        'Zend\I18n',
        'Zend\Paginator',
        'Zend\Mvc\Plugin\Prg',
        'Zend\Mvc\Plugin\Identity',
        'Zend\Mvc\Plugin\FlashMessenger',
        'Zend\Mvc\Plugin\FilePrg',
        'Zend\Mvc\I18n',
        'Zend\Cache',
        'Zend\Router',
        'Zend\Validator',
        'DoctrineModule',
        'DoctrineORMModule',
        'ZfbUser'
    ],

    // These are various options for the listeners attached to the ModuleManager
    'module_listener_options' => [
        // This should be an array of paths in which modules reside.
        // If a string key is provided, the listener will consider that a module
        // namespace, the value of that key the specific path to that module's
        // Module class.
        'module_paths' => [
            './module',
            './vendor',
        ],

        // An array of paths from which to glob configuration files after
        // modules are loaded. These effectively override configuration
        // provided by modules themselves. Paths may use GLOB_BRACE notation.
        'config_glob_paths' => [
            realpath(__DIR__) . '/_data/config/{{,*.}global,{,*.}local}.php',
        ],

        // Whether or not to enable a configuration cache.
        // If enabled, the merged configuration will be cached and used in
        // subsequent requests.
        'config_cache_enabled' => true,

        // The key used to create the configuration cache file name.
        'config_cache_key' => 'application.config.cache',

        // Whether or not to enable a module class map cache.
        // If enabled, creates a module class map cache which will be used
        // by in future requests, to reduce the autoloading process.
        'module_map_cache_enabled' => true,

        // The key used to create the class map cache file name.
        'module_map_cache_key' => 'application.module.cache',

        // The path in which to cache merged configuration.
        'cache_dir' => realpath(__DIR__) . '/_data/cache/',
    ],
];
