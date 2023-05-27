<?php

namespace api\App\Controllers;

class UploadController extends ControllerBase
{
    public function imgAction()
    {
        $this->ajaxReturn('ok', 200, ['src'=>rand(),'file'=>'']);
    }

}