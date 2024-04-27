<?php

namespace api\App\Controllers;

use api\App\Service\UserService;

class UserController extends BaseController
{

    /**
     * 用户登陆校验接口
     * @SkipTokenValidation [校验token]
     * @return void|null
     */
    public function loginAction()
    {
        $username = $this->request->getPost('username', 'trim');
        $password = $this->request->getPost('password', 'trim');
        $info = UserService::getInstance()->validateUserInfo($username, $password);
        if (empty($info)) {
            return $this->ajaxReturn('账号或密码错误', 200, '');
        }
        return $this->ajaxReturn('ok', 200, $info);
    }

    /**
     * @return void
     */
    public function infoAction()
    {

        $data = [
            'roles' => ['admin'],
            'router_arr' => [1,2,3],
            'introduction' => 'I am a super administrator',
            'avatar' => 'https://wpimg.wallstcn.com/f778738c-e4f8-4870-b634-56703b4acafe.gif',
            'name' => 'Super Admin',
        ];
        return $this->ajaxReturn('ok', 200, $data);
    }

    public function logoutAction()
    {
        return $this->ajaxReturn('ok', 200, '');
    }

}