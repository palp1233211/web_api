<?php


if (!function_exists('random_str')) {
    /**
     * 获取随机字符串
     * @param $length
     * @return string
     */
    function random_str($length = 12)
    {
        $array = [
            1 => range(0, 9),
            2 => array_merge(range('a', 'z'), range('A', 'Z')),
            3 => ['!','@','(',')','-','_','+','%'],
        ];
        $array = array_flip(array_merge(...$array));
        return implode('', array_rand($array, $length));

    }
}
if (!function_exists('env')) {
    function env($key, $default = null)
    {
        $project_name = PROJECT_NAME;
        return \Yaconf::get($project_name.'.'.$key, $default);
    }
}

if (!function_exists('md5_salt')) {
    /**
     * 加盐后的md5值
     * @param $str
     * @return string
     */
    function md5_salt($str)
    {
        $di = \Phalcon\Di::getDefault();
        $salt = $di->get('config')->application->md5_salt;
        return md5($str.$salt);
    }
}

