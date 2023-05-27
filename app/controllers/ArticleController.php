<?php

namespace api\App\Controllers;

class ArticleController extends ControllerBase
{
    public function createAction(){
        $abnormal_id =$this->request->get('abnormal_id', 'int');
        $name = $this->request->get('name', 'trim');

        $this->ajaxReturn('ok',200, [$name]);
    }
    public function pvAction(){
        $name = $this->request->get('name', 'trim');

        $this->ajaxReturn('ok',200, [$name]);
    }
}