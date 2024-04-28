<?php

namespace api\App\Service;

use api\App\Library\PhalconBaseLogger;
use api\App\Models\BaseModel;
use Phalcon\Db\Adapter\Pdo\Mysql;
use Phalcon\Cache\Backend\Redis;
use Phalcon\Di;
use api\App\Traits\Singleton;

class BaseService
{
    use Singleton;

    /**
     * @return \Phalcon\DiInterface
     */
    public function getDI()
    {
        return Di::getDefault();
    }

    /**
     * @return PhalconBaseLogger
     */
    public function getLogger()
    {
        return $this->getDI()->get('logger');
    }

    /**
     * 获取redis对象
     * @return Redis
     */
    public function getRedis()
    {
        return $this->getDi()->get('redis');
    }

    /**
     * DB写权限
     * @return Mysql
     */
    public function getWriteDB()
    {
        return (new BaseModel())->getWriteDB();
    }



}