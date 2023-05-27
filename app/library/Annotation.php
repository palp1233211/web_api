<?php

namespace api\App\Library;

use Phalcon\Annotations\Adapter\Memory as AnnotationsAdapter;
use Phalcon\Di;
use api\app\Traits\Singleton;
use Phalcon\Annotations\Collection;

/**
 * 注解操作类
 */
class Annotation
{
    use Singleton;

    /**
     * @var AnnotationsAdapter|null
     */
    public $annotationsAdapter = null;
    /**
     * 类名
     * @var string
     */
    public $controllerName = '';

    /**
     * 方法名
     * @var string
     */
    public $actionName = '';

    /**
     * @var bool|Collection
     */
    public $controllerAnnotation = false;

    /**
     * @var bool|Collection
     */
    public $methodAnnotation = false;

    public function __construct($controllerName = '', $actionName = '')
    {
        $di = Di::getDefault();
        $dispatcher = $di->get('dispatcher');
        $this->annotationsAdapter = new AnnotationsAdapter();
        $this->controllerName = $controllerName ?:  $dispatcher->getControllerClass();
        $this->actionName = $actionName ?:  $dispatcher->getActiveMethod();
        $this->setAnnotations();
    }

    /**
     * 设置类注解和方法的注解
     * @return void
     */
    private function setAnnotations()
    {
        $controllerName = $this->controllerName;
        $actionName = $this->actionName;
        // 创建注解适配器
        $annotationsAdapter = $this->annotationsAdapter;
        // 获取控制器注解
        $controllerAnnotations = $annotationsAdapter->get($controllerName);
        $controllerAnnotation = $controllerAnnotations->getClassAnnotations();
        // 获取控制器的所有方法注解
        $methodAnnotation = $annotationsAdapter->getMethod($controllerName, $actionName);
        $this->controllerAnnotation = $controllerAnnotation;
        $this->methodAnnotation = $methodAnnotation;
    }


    /**
     * 获取方法上所有的注解名称
     * @return array
     */
    public function getMethodNames()
    {
        $methodNames = [];
        $methodAnnotation = $this->methodAnnotation;
        foreach ($methodAnnotation->getAnnotations() as $annotation) {
            if ($annotation->getName() == 'return') {
                continue;
            }
            $methodNames[] = $annotation->getName();
        }
        return $methodNames;
    }


    /**
     * 判断方法注解是否存在
     * @param $annotation
     * @return bool
     */
    public function hasMethodAnnotation($annotation)
    {
        return $this->methodAnnotation->has($annotation);
    }


    public function parse()
    {
        $methodAnnotation = $this->methodAnnotation;

        // 处理控制器注解
//        if ($controllerAnnotation->has('RoutePrefix')) {
//            $routePrefix = $controllerAnnotation->get('RoutePrefix')->getArgument(0);
//            $dispatcher->setControllerPrefix($routePrefix);
//        }

        // 处理动作注解
        if (isset($methodAnnotation)) {
            foreach ($methodAnnotation->getAnnotations() as $annotation) {
                $a = $annotation;
                if ($annotation->getName() == 'return') {
                    continue;
                }
                var_dump($a->getName());
                var_dump($a->getArguments());
            }
        }
    }



}