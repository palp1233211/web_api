<?php
namespace api\App\Controllers;

class IndexController extends ControllerBase
{

    public function indexAction()
    {

    }

    public function notfoundAction()
    {
        var_dump(env('host'));
        $this->ajaxReturn('error', 404 , '');
    }
}

