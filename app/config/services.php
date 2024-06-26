<?php

use Phalcon\Mvc\View;
use Phalcon\Mvc\View\Engine\Php as PhpEngine;
use Phalcon\Url as UrlResolver;
use Phalcon\Mvc\View\Engine\Volt as VoltEngine;
use Phalcon\Mvc\Model\Metadata\Memory as MetaDataAdapter;
use Phalcon\Annotations\Adapter\Memory as AnnotationsAdapter;
use Phalcon\Session\Adapter\Stream as SessionAdapter;
use Phalcon\Flash\Direct as Flash;
use Phalcon\Dispatcher\Exception as Dispatcher;
use Phalcon\Events\Manager as EventsManager;
use Phalcon\Events\Event;
use Phalcon\Mvc\Dispatcher as MvcDispatcher;
use Phalcon\Annotations\Annotation;
use Phalcon\Annotations\Collection;

/**
 * Shared configuration service
 */
$di->setShared('config', function () {
    return include APP_PATH . "/config/config.php";
});

// 创建注解适配器
$annotationsAdapter = new AnnotationsAdapter();


$di->setShared(
    'dispatcher',
    function () {
        // Create an EventsManager
        $eventsManager = new EventsManager();

        // Attach a listener
        $eventsManager->attach(
            'dispatch:beforeException',
            function (Event $event, $dispatcher, Exception $exception) {

                // Alternative way, controller or action doesn't exist
                switch ($exception->getCode()) {
                    case Dispatcher::EXCEPTION_HANDLER_NOT_FOUND:
                    case Dispatcher::EXCEPTION_ACTION_NOT_FOUND:
                        $dispatcher->forward(
                            [
                                'controller' => 'index',
                                'action'     => 'notfound',
                            ]
                        );
                        return false;
                }
            }
        );

        $dispatcher = new MvcDispatcher();

        //设置默认命名空间
        $dispatcher->setDefaultNamespace(
            'api\App\Controllers'
        );

        // Bind the EventsManager to the dispatcher
        $dispatcher->setEventsManager($eventsManager);

        return $dispatcher;
    }
);

/**
 * The URL component is used to generate all kind of urls in the application
 */
$di->setShared('url', function () {
    $config = $this->getConfig();

    $url = new UrlResolver();
    $url->setBaseUri($config->application->baseUri);

    return $url;
});

/**
 * Setting up the view component
 */
$di->setShared('view', function () {
    $config = $this->getConfig();

    $view = new View();
    $view->setDI($this);
    $view->setViewsDir($config->application->viewsDir);

    $view->registerEngines([
        '.volt' => function ($view) {
            $config = $this->getConfig();

            $volt = new VoltEngine($view, $this);

            $volt->setOptions([
                'path' => $config->application->cacheDir,
                'separator' => '_'
            ]);

            return $volt;
        },
        '.phtml' => PhpEngine::class

    ]);

    return $view;
});

/**
 * Database connection is created based in the parameters defined in the configuration file
 */
$di->setShared('redis', function () {
    $config = $this->getConfig();
    $serializerFactory = new \Phalcon\Storage\SerializerFactory();
    $params = [
        'host'  => $config->redis->host,
        'prefix' => $config->redis->prefix,
        'port' => $config->redis->port,
        'auth' => $config->redis->auth,
        'persistent' => false,
        'lifetime' => $config->redis->lifetime,
        'defaultSerializer' => 'Json'
    ];

    return new Phalcon\Cache\Adapter\Redis($serializerFactory, $params);
});

/**
 * Database connection is created based in the parameters defined in the configuration file
 */
$di->setShared('db', function () {
    $config = $this->getConfig();

    $class = 'Phalcon\Db\Adapter\Pdo\\' . $config->database->adapter;
    $params = [
        'host'     => $config->database->host,
        'username' => $config->database->username,
        'password' => $config->database->password,
        'dbname'   => $config->database->dbname,
        'charset'  => $config->database->charset
    ];

    if ($config->database->adapter == 'Postgresql') {
        unset($params['charset']);
    }

    return new $class($params);
});


/**
 * If the configuration specify the use of metadata adapter use it or use memory otherwise
 */
$di->setShared('modelsMetadata', function () {
    return new MetaDataAdapter();
});

/**
 * Register the session flash service with the Twitter Bootstrap classes
 */
$di->set('flash', function () {
    return new Flash([
        'error'   => 'alert alert-danger',
        'success' => 'alert alert-success',
        'notice'  => 'alert alert-info',
        'warning' => 'alert alert-warning'
    ]);
});

/**
 * Start the session the first time some component request the session service
 */
$di->setShared('session', function () {
    $session = new SessionAdapter();
    $session->start();

    return $session;
});


/**
 * DI注册日志服务
 */
$di->setShared('logger', function () use ($di) {
    $config = $this->getConfig(); //使用DI里注册的config服务
    $day = date('Ymd');
    $path = explode('/',strtolower($_SERVER['REQUEST_URI']));
    $controller = $path[1];
    $svc_controllers = ['svc','svcv2'];
    if(in_array($controller,$svc_controllers)){
        $logger_path = 'svclog';
    }else{
        $logger_path = 'log';
    }
    $logger = new \api\App\Library\PhalconBaseLogger($config->application->runtimeDir . $logger_path ."/log_{$day}.log");
    $logger = new \Phalcon\Logger(
        'messages',
        [
            'main' => $logger,
        ]
    );
    return $logger;
});
