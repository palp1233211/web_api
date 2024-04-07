<?php
namespace api\App\Controllers;

class IndexController extends BaseController
{

    public function indexAction()
    {
//        $response = new \Phalcon\Http\Response();
//        $this->response->setJsonContent(['key' => 'value']);
//        return $this->response;
//        $response->setJsonContent(['key' => 'value']);
//        return $response;
//        return 12;
//        echo "Hello, Phalcon!";
        return $this->swooleReturn('swoole','12312');
    }
    public function demoAction()
    {
        $this->ajaxReturn('demos','12312');
    }


    public function notfoundAction()
    {
        $this->ajaxReturn('ok', 200 , ['token'=>'123']);
    }
}

