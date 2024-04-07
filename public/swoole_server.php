<?php
use Phalcon\Di\FactoryDefault;

error_reporting(E_ALL);

define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', BASE_PATH . '/app');

try {

    require_once APP_PATH .'/common/functions.php';

    /**
     * 常量
     */
    require_once APP_PATH .'/config/const.php';

    /**
     * The FactoryDefault Dependency Injector automatically registers
     * the services that provide a full stack framework.
     */
    $di = new FactoryDefault();

    /**
     * Handle routes
     */
    include APP_PATH . '/config/router.php';

    /**
     * Read services
     */
    include APP_PATH . '/config/services.php';

    /**
     * Get config service for use in inline setup below
     */
    $config = $di->getConfig();

    /**
     * Include Autoloader
     */
    include APP_PATH . '/config/loader.php';

    $http = new Swoole\Http\Server("0.0.0.0", 8882);

    $http->on("start", function ($server) {
        echo "Swoole HTTP Server is started at http://127.0.0.1:8882\n";
    });
    /**
     * Handle the request
     */
    $app = new \Phalcon\Mvc\Application($di);

    $p_request = new Phalcon\Http\Request();

    $http->on("request", function ($request, $response) use ($app,$p_request) {
        // 转换 Swoole 请求到 Phalcon
        $_SERVER = [];
        if (isset($request->server)) {
            foreach ($request->server as $key => $value) {
                $_SERVER[strtoupper($key)] = $value;
            }
        }
        if (isset($request->header)) {
            foreach ($request->header as $key => $value) {
                $_SERVER[strtoupper($key)] = $value;
            }
        }
        $_GET = [];
        if (isset($request->get)) {
            $_GET = $request->get;
        }
        $_POST = [];
        if (isset($request->post)) {
            $_POST = $request->post;
        }
        $_COOKIE = [];
        if (isset($request->cookie)) {
            $_COOKIE = $request->cookie;
        }
        $_FILES = [];
        if (isset($request->files)) {
            $_FILES = $request->files;
        }

        // 处理应用程序的请求并获取响应
        ob_start();

        $result = $app->handle($request->server['request_uri'])->getContent();
//        $result = ob_get_contents();
        ob_end_clean();
        // 发送响应
//        $response->header("Content-Type", "application/json");
        $response->end($result);
    });
    $http->start();

} catch (\Exception $e) {
    echo $e->getMessage() . '<br>';
    echo '<pre>' . $e->getTraceAsString() . '</pre>';
}
