<?php

/**
 * Phalcon日志扩展
 */

namespace api\App\Library;

use Phalcon\Logger\AdapterInterface;
use const JSON_UNESCAPED_UNICODE;

class PhalconBaseLogger extends \Phalcon\Logger\Adapter\Stream
{

    /**
     * 设置错误信息
     * @param $log
     * @return void
     */
    private function getDebugInfo($log)
    {
        $debugInfo = debug_backtrace();
        $log_info = [];
        if (isset($debugInfo[1])) {
            $debugInfo = $debugInfo[1];
            $log_info['class'] = $debugInfo['class'] ?? '';
            $log_info['function'] = $debugInfo['function'] ?? '';
        } else {
            $log_info['class'] = __CLASS__;
            $log_info['function'] = __FUNCTION__;
        }
        $log_info['type'] ='%type%';
        $log_info['timestamp'] = '%date%';
        $log_info['mysql'] =$log;
//        is_array($log) && $log = json_encode($log);
        $log_info = json_encode($log_info, JSON_UNESCAPED_UNICODE);
        $formatter = new \Phalcon\Logger\Formatter\Line($log_info);
        $formatter->setDateFormat('Y-m-d H:i:s');
        $this->setFormatter($formatter);
    }

    /**
     * 日志记录
     * @param $log
     * @param array|null $context
     * @return AdapterInterface
     */
    public function error($log, array $context = null)
    {
        $this->getDebugInfo($log);
        return parent::error("", $context);
    }

    /**
     * 日志记录
     * @param $log
     * @param array|null $context
     * @return AdapterInterface
     */
    public function info($log, array $context = null)
    {
        $this->getDebugInfo($log);
        return parent::info("", $context);
    }


}



