<?php

$router = $di->getRouter();

$namespace = 'api\App\Controllers';

// Define your routes here
$routerRules = [
    '/:controller/:action/:params' => array(
        'namespace' => $namespace,
        'controller'=>1,
        'action'=>2,
        'params' => 3,
    ),
    '/prod-api/:controller/:action/:params' => array(
        'namespace' => $namespace,
        'controller'=>1,
        'action'=>2,
        'params' => 3,
    ),
    //默认路由
    '/' => array(
        'namespace' =>  $namespace,
        'controller' => 'index',
        'action' => 'index',
    ),
];

//注册路由
$di->set('router', function () use ($routerRules) {
    $router = new \Phalcon\Mvc\Router();
    $router->notFound(
        [
            "controller" => "index",
            "action" => "notfound",
        ]
    );


    foreach ($routerRules as $key => $value) {
        $router->add($key, $value);
    }
    $router->handle();
    return $router;
});

