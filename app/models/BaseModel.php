<?php
namespace api\App\Models;

use api\App\Library\PhalconBaseLogger;

class BaseModel extends \Phalcon\Mvc\Model implements \Phalcon\Mvc\ModelInterface
{
    const WRITE_DB_PHALCON_DI_NAME = 'db';
    const READ_DB_PHALCON_DI_NAME  = 'db';


    /**
     * @return PhalconBaseLogger
     */
    public function getLogger()
    {
        return $this -> getDI() -> get('logger');
    }
}