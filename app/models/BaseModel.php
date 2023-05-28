<?php
namespace api\App\Models;

use api\App\Library\PhalconBaseLogger;
use Phalcon\Db\Adapter\Pdo\Mysql;

class BaseModel extends \Phalcon\Mvc\Model implements \Phalcon\Mvc\ModelInterface
{
    const WRITE_DB_PHALCON_DI_NAME = 'db';
    const READ_DB_PHALCON_DI_NAME  = 'db';

    /**
     * @return Mysql
     */
    public function getWriteDB()
    {
        return $this->getDI()->get(self::WRITE_DB_PHALCON_DI_NAME);
    }

    /**
     * @return PhalconBaseLogger
     */
    public function getLogger()
    {
        return $this -> getDI() -> get('logger');
    }
}