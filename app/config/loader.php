<?php

use Phalcon\Annotations\Adapter\Memory as AnnotationsAdapter;

$loader = new \Phalcon\Loader();

/**
 * 注册文件，在自动加载时读取文件，你可以通过下面的链接来查看如何配置
 * https://www.kancloud.cn/jaya1992/phalcon_doc_zh/753270
 */


$loader->registerNamespaces(
    [
        //将其下的类都注册为某命名空间的类，以便在需要的时候将其加载
        'api\App\Controllers' => $config->application->controllersDir,
        'api\App\Service' => $config->application->serviceDir,
        'api\App\Models' => $config->application->modelsDir,
        'api\App\Library' => $config->application->libraryDir,
        'api\app\Traits' => $config->application->traitsDir,
        'api\app\Exception' => $config->application->exceptionDir,
    ]
)->registerDirs(
    [
        //注册可以找到类的目录，在性能方面不建议使用此选项，因为Phalcon需要在每个文件夹上执行大量文件统计信息，查找与该类名称相同的文件。按相关顺序注册目录很重要。
    ]
)->registerFiles(
    [
        //这些文件自动加载到 register() 方法中。
        //APP_PATH .'/common/functions.php',
    ]
)->register();
