<?php
namespace api\App\Controllers;

use api\App\Library\Annotation;
use api\App\Service\UserService;
use Phalcon\Mvc\Controller;

class BaseController extends Controller
{
    /**
     * @var \api\App\Library\PhalconBaseLogger
     */
    public $logger;

    public function initialize()
    {
        //是否校验token
        $is_validate_token = Annotation::getInstance()->hasMethodAnnotation('SkipTokenValidation');
        if (!$is_validate_token) {
            //校验是否登陆
//            $this->validateLogin();
        }
        $this->logger = $this->getDI()->get('logger');
    }

    /**
     * 校验是否登陆
     * @return bool
     */
    public function validateLogin()
    {
        $token = $this->request->get('token');
        $username = $this->request->get('username');
        if (empty($token) || empty($username)) {
            $this->ajaxReturn('error', 2001, []);
        }
        $user_service = UserService::getInstance();
        if (!$user_service->isTokenValid($token, $username)) {
            $this->ajaxReturn('error', 2002, []);
        }
        return true;
    }

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

    public function swooleReturn($message, $code=1, $data=[])
    {
        $result = array(
            'code' => $code,
            'msg' => $message,
            'data' => $data,
        );
        $this->response->setJsonContent($result);
        return $this->response;
    }
}
