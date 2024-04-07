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
    '/admin/:controller/:action/:params' => array(
        'namespace' => $namespace,
        'controller'=>1,
        'action'=>2,
        'params' => 3,
    ),
    '/swoole/:controller/:action/:params' => array(
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

foreach ($routerRules as $key => $value) {
    $router->add($key, $value);
}