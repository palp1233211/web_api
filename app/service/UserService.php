<?php

namespace api\App\Service;

use api\app\Traits\Singleton;
use api\App\Models\UserModel;

class UserService extends BaseService
{
    use Singleton;

    /**
     * 判断用户是否存在
     * @param $username
     * @param $password
     * @return array
     */
    public function validateUserInfo($username, $password): array
    {
        //校验账号
        $password = md5_salt($password);
        $status = UserModel::getInstance()->isValidCredentials($username, $password);
        if (!$status) {
            return [];
        }
        //设置token
        $token = md5_salt($username . microtime(true) * 1000);
        $redis = $this->getRedis();
        $user_token_key = $username.'_token';
        $history_token =  $redis->get($user_token_key);
        //防止多次登陆历史token一直存在
        if ($history_token) {
            $redis->delete($history_token);
        }
        $redis->save($token, 1, 24*3600);
        $redis->save($user_token_key, $token, 24*3600);
        return ['token'=>$token];
    }

    /**
     * token是否有效
     * @param $token
     * @return bool
     */
    public function isTokenValid($token)
    {
        $redis = $this->getRedis();
        return $redis->exists($token);
    }

}