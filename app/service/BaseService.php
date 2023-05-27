<?php

namespace api\App\Service;

use Phalcon\Cache\Backend\Redis;
use Phalcon\Di;
use api\app\Traits\Singleton;

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
     * 获取redis对象
     * @return Redis
     */
    public function getRedis()
    {
        return $this->getDi()->get('redis');
    }


}