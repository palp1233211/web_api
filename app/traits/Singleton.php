<?php

namespace api\app\Traits;

/**
 * Trait Singleton
 * 生产单例
 * @package FlashExpress\bi\App\BLL
 */
trait Singleton
{
    private static $instance;

    public static function getInstance(...$args)
    {
        if (!isset(self::$instance)) {
            self::$instance = new static(...$args);
        }
        return self::$instance;
    }
}