<?php
namespace api\App\Controllers;

class IndexController extends BaseController
{

    public function indexAction()
    {
        return $this->ajaxReturn('swoole','12312');
    }
    public function demoAction()
    {
        return $this->ajaxReturn('demos','12312');
    }


    public function notfoundAction()
    {
        return $this->ajaxReturn('ok', 200 , ['token'=>'123']);
    }
}

