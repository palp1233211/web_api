<?php

use api\App\Exception\RequestException;
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

    $http = new Swoole\Http\Server("0.0.0.0", 8882, SWOOLE_BASE);
    $http->set([
        'worker_num' => 4,
        'max_wait_time' => 60,
        'reload_async' => true,
        'max_request'   => 100,
    ]);
    $http->on("start", function ($server) {
        echo "Swoole HTTP Server is started at http://127.0.0.1:8882\n";
    });
    /**
     * Handle the request
     */
    $app = new \Phalcon\Mvc\Application($di);

    $http->on("request", function ($request, $response) use ($app,$di) {
        $di->setShared('Response', $response);
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
        $_REQUEST = array_merge($_GET, $_POST, $_COOKIE, $_FILES);

        if ($request->server['path_info'] == '/favicon.ico' || $request->server['request_uri'] == '/favicon.ico') {
            $response->end();
            return;
        }

        try {
            // 处理应用程序的请求并获取响应
            ob_start();
            // 处理请求
            $output = $app->handle($request->server['request_uri'])->getContent();
            ob_end_clean();
            // 将输出发送给客户端
            $response->end($output);
        }catch (RequestException $e) {
            $response->end(json_encode(['code'=>$e->getCode(),'msg'=>$e->getMessage()]));
        }
    });
    $http->start();

} catch (\Exception $e) {
    echo $e->getMessage() . '<br>';
    echo '<pre>' . $e->getTraceAsString() . '</pre>';
}
