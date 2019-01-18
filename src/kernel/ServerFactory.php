<?php


namespace PaoPaoTo\kernel;

use PaoPaoTo\kernel\Exception\BadRequestException;


/**
 * Class ServerFactory
 * 服务工厂
 * @package PaoPaoTo\kernel
 * @author: applosl <121955907@qq.com> 2019/1/18 11:24 AM
 */
class ServerFactory {

    /**
     * 服务创建工厂 处理一系列复杂的 服务模块 控制器 方法的检测
     * 及 初始化 服务的初始执行控制器及方法
     * @param PPT $server
     * @return PPT
     * @throws Exception\BadRequestException
     */
    public static function buildServer(PPT $server) {
        $servicePath = $server->route->getServerPath();
        list($serviceName, $controlName, $actionName) = $servicePath;

        if (empty($serviceName)) {
            throw new BadRequestException('错误的服务模块', 404);
        }
        if (empty($controlName) || empty($actionName)) {
            throw new BadRequestException('错误的控制名 或 方法名', 404);
        }

        // 检查是否含有对应的控制器
        $controlClassName = '\\' . ucfirst($serviceName) . '\\Controller\\' . ucfirst($controlName);

        if (!class_exists($controlClassName)) {
            throw new BadRequestException('找不到对应的控制器名', 404);
        }

        $controllerClass = new $controlClassName();
        // 检查是否含有对应的方法
        if (!method_exists($controllerClass, $actionName) || !is_callable(array(
                $controllerClass,
                $actionName
            ))) {
            throw new BadRequestException('找不到对应的方法名', 404);
        }

        $server->setInitController($controllerClass);
        $server->setInitAction($actionName);
        return $server;
    }
}
