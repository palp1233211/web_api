<?php

$loader = new \Phalcon\Loader();

/**
 * We're a registering a set of directories taken from the configuration file
 */

$loader->registerNamespaces(
    [
        //将其下的类都注册为某命名空间的类，以便在需要的时候将其加载
        'api\App\Controllers' => $config->application->controllersDir,
    ]
)->registerDirs(
    [
        $config->application->controllersDir,
        $config->application->modelsDir
    ]
)->register();
