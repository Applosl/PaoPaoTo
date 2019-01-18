<?php
/**
 * @author: applosl <121955907@qq.com> 2019/1/17 2:17 PM
 */

namespace PaoPaoTo\kernel;


/**
 * Class Controller
 * 控制器基础类
 * @package PaoPaoTo\kernel
 * @author: applosl <121955907@qq.com> 2019/1/17 2:17 PM
 */
class Controller {
    protected $actionName = '';

    // TODO 为了简化其控制器的操作 这里可以简单将封装几个简单的Request的属性 考虑性能 看是否需要用引用
    /**
     * 初始化 参数注入 方法调用
     * @param $actionName
     * @return mixed
     */
    public function init($actionName) {
        $this->actionName = $actionName;
        return $this->$actionName();
    }

    /**
     * 获取当前控制器名
     * @return bool|string
     */
    public function getControllerName() {
//        return substr(static::class, strrpos(static::class, '\\')+1);
    }

    /**
     * 获取方法名
     * @return string
     */
    public function getActionName(){
        return $this->actionName;
    }
}
