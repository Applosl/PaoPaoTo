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
    protected $controllerName = '';
    protected $actionName = '';

    // TODO 为了简化其控制器的操作 这里可以简单将封装几个简单的Request的属性 考虑性能 看是否需要用引用

    public function init($actionName) {
        $this->actionName = $actionName;
        $this->$actionName();
    }
}
