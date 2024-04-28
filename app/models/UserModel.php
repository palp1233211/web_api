<?php
namespace api\App\Models;

use Phalcon\Db\Exception;
use api\App\Traits\Singleton;

class UserModel extends BaseModel
{
    use Singleton;

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function initialize()
    {
        $this->setSource("user");
    }

    /**
     * 判断用户信息是否正确
     * @param $username
     * @param $password
     * @return bool
     */
    public function isValidCredentials($username, $password): bool
    {
        try {
            $count = static::count([
                'conditions' => ' username = :username: and  password = :password:',
                'bind' => [
                    'username' => $username,
                    'password' => $password,
                ],
            ]);
            return $count > 0;
        } catch (\Exception $e) {
            $this->getLogger()->error('登陆检测用户信息报错：'.$e->getMessage());
        }
        return false;
    }
}