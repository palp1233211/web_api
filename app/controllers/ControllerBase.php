<?php
namespace api\App\Controllers;

use Phalcon\Mvc\Controller;

class ControllerBase extends Controller
{
    /**
     * 返回ajax响应
     * @param $message
     * @param $code
     * @param $data
     * @return void
     */
    public function ajaxReturn($message, $code=1, $data=[])
    {
        $result = array(
            'code' => $code,
            'msg' => $message,
            'data' => $data,
        );
        $this -> response -> setJsonContent($result);
        $this -> response -> send();
        exit;
    }

}
