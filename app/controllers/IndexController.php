<?php
namespace api\App\Controllers;

class IndexController extends ControllerBase
{

    public function indexAction()
    {

    }

    public function notfoundAction()
    {
        $this->ajaxReturn('ok', 200 , ['token'=>'123']);
    }
}

