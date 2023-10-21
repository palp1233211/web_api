<?php
namespace api\App\Controllers;

class IndexController extends BaseController
{

    public function indexAction()
    {

    }

    public function notfoundAction()
    {
        $this->ajaxReturn('ok', 200 , ['token'=>'123']);
    }
}

