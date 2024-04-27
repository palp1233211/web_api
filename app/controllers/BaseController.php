<?php
namespace api\App\Controllers;

use api\App\Exception\RequestException;
use api\App\Library\Annotation;
use api\App\Service\UserService;
use Phalcon\Mvc\Controller;

class BaseController extends Controller
{
    /**
     * @var \api\App\Library\PhalconBaseLogger
     */
    public $logger;

    /**
     * @throws RequestException
     */
    public function initialize()
    {
        $this->logger = $this->getDI()->get('logger');
        //是否校验token
        $is_validate_token = Annotation::getInstance()->hasMethodAnnotation('SkipTokenValidation');
        if (!$is_validate_token) {
            //校验是否登陆
            $this->validateLogin();
        }
    }

    /**
     * 校验是否登陆
     * @return bool
     * @throws RequestException
     */
    public function validateLogin()
    {
        $token = $this->request->get('token');
        $username = $this->request->get('username');
        if (empty($token) || empty($username)) {
            throw new RequestException('error', 2001);
        }
        $user_service = UserService::getInstance();
        if (!$user_service->isTokenValid($token, $username)) {
            throw new RequestException('error', 2002);
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
//    public function ajaxReturn($message, $code=1, $data=[])
//    {
//        $result = array(
//            'code' => $code,
//            'msg' => $message,
//            'data' => $data,
//        );
//        $this -> response -> setJsonContent($result);
//        $this -> response -> send();
//        exit;
//    }

    /**
     * @param $message
     * @param $code
     * @param $data
     */
    public function ajaxReturn($message, $code=1, $data=[])
    {
        $result = [
            'code' => $code,
            'msg' => $message,
            'data' => $data,
        ];
        return $this->response->setJsonContent($result);
    }
}
