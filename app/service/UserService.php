<?php

namespace api\App\Service;

use api\App\Traits\Singleton;
use api\App\Models\UserModel;

class UserService extends BaseService
{
    use Singleton;

    public static $token_key_suffix = '_token';

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
        $user_token_key = $username.self::$token_key_suffix;
        $history_token =  $redis->get($user_token_key);
        //防止多次登陆历史token一直存在
        if ($history_token) {
            $redis->delete($history_token);
        }
        $redis->set($user_token_key, $token, 24*3600);
        return ['token'=>$token];
    }

    /**
     * token是否有效
     * @param $token
     * @param $username
     * @return bool
     */
    public function isTokenValid($token, $username)
    {
        $redis = $this->getRedis();
        return $redis->get($username.self::$token_key_suffix) == $token;
    }

    /**
     * 删除用户token
     * @param $username
     * @return bool
     */
    public function delUserToken($username): bool
    {
        return $this->getRedis()->delete($username.self::$token_key_suffix);
    }

}