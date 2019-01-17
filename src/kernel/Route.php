<?php
/**
 * @author: applosl <121955907@qq.com> 2019/1/17 1:51 PM
 */

namespace PaoPaoTo\kernel;

use PaoPaoTo\kernel\Exception\BadRequestException;


/**
 * Class Route
 * 路由组件类
 * @package PaoPaoTo\kernel
 * @author: applosl <121955907@qq.com> 2019/1/17 1:51 PM
 */
class Route {
    public $serviceName = '';
    public $controlName = '';
    public $actionName = '';
    /**
     * @var Controller
     */
    protected $controllerClass = null;

    /**
     * 生成服务
     * @param array $servicePath 服务路由
     * @throws BadRequestException
     */
    public function generateServer($servicePath) {
        list($this->serviceName, $this->controlName, $this->actionName) = $servicePath;
        $this->checkPath();
        return $this->controllerClass->init($this->actionName);
    }

    /**
     * 检查路由异常情况
     * @throws BadRequestException
     */
    public function checkPath() {
        if (empty($this->serviceName)) {
            throw new BadRequestException('错误的服务模块');
        }
        if (empty($this->controlName) || empty($this->actionName)) {
            throw new BadRequestException('错误的控制名 或 方法名');
        }

        // 检查是否含有对应的控制器
        $controlClassName = '\\' . ucfirst($this->serviceName) . '\\Controller\\' . ucfirst($this->controlName);

        if (!class_exists($controlClassName)) {
            throw new BadRequestException('找不到对应的控制器名');
        }

        $this->controllerClass = new $controlClassName();
        // 检查是否含有对应的方法
        if (!method_exists($this->controllerClass, $this->actionName) || !is_callable(array(
                $this->controllerClass,
                $this->actionName
            ))) {
            throw new BadRequestException('找不到对应的方法名');
        }
    }
}
