<?php

namespace api\App\Controllers;

class UploadController extends ControllerBase
{
    public function imgAction()
    {
        $this->ajaxReturn('ok', 200, ['src'=>"https://wpimg.wallstcn.com/f778738c-e4f8-4870-b634-56703b4acafe.gif",'file'=>'']);
    }

}