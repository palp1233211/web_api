<?php
/*
 * Modified: prepend directory path of current file, because of this file own different ENV under between Apache and command line.
 * NOTE: please remove this comment.
 */
defined('BASE_PATH') || define('BASE_PATH', getenv('BASE_PATH') ?: realpath(dirname(__FILE__) . '/../..'));
defined('APP_PATH') || define('APP_PATH', BASE_PATH . '/app');
defined('PROJECT_NAME') || define('PROJECT_NAME', 'web_api');

return new \Phalcon\Config([
    'database' => [
        'adapter'     => env('database.adapter','Mysql'),
        'host'        => env('database.host'),
        'username'    => env('database.username'),
        'password'    => env('database.password'),
        'dbname'      => env('database.dbname'),
        'charset'     => 'utf8',
    ],
    'redis' => [
        'prefix' => env('redis.prefix'),
        'host' => env('redis.host'),
        'port' => env('redis.port'),
        'auth' => env('redis.auth'),
        'lifetime'=> env('redis.lifetime')
    ],
    'application' => [
        'appDir'         => APP_PATH . '/',
        'controllersDir' => APP_PATH . '/controllers/',
        'serviceDir'     => APP_PATH . '/service/',
        'modelsDir'      => APP_PATH . '/models/',
        'migrationsDir'  => APP_PATH . '/migrations/',
        'viewsDir'       => APP_PATH . '/views/',
        'pluginsDir'     => APP_PATH . '/plugins/',
        'libraryDir'     => APP_PATH . '/library/',
        'cacheDir'       => BASE_PATH . '/cache/',
        'traitsDir'      => APP_PATH . '/traits/',
        'runtimeDir'     => APP_PATH . '/runtime/',
        'exceptionDir'   => APP_PATH . '/exception/',
        // This allows the baseUri to be understand project paths that are not in the root directory
        // of the webpspace.  This will break if the public/index.php entry point is moved or
        // possibly if the web server rewrite rules are changed. This can also be set to a static path.
        'baseUri'        => preg_replace('/public([\/\\\\])index.php$/', '', $_SERVER["PHP_SELF"]),
        'md5_salt'       => 'web_api',
        'logLevel'       => env('log_level', \Phalcon\Logger::INFO),
    ]
]);
