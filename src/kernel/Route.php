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

    private $pathInfoMode = true;

    /**
     * 返回服务的路由
     * @return array [service,control,action]
     * @throws BadRequestException
     */
    public function getServerPath() {
        // PathInfo 模式开启
        $requestUri = substr($_SERVER['REQUEST_URI'], 0, strpos($_SERVER['REQUEST_URI'], '?'));
        $pathInfoArr = array_values(array_filter(explode('/', $requestUri)));

        $service = 'App'; // 默认服务模块名 TODO 可配置
        $control = 'index'; // 默认控制器名 TODO 可配置
        $action = 'index'; // 默认方法名 TODO 可配置

        // TODO 看有没有更优雅的方式处理这段程序
        switch (count($pathInfoArr)) {
            case 3:
                list($service, $control, $action) = $pathInfoArr;
                break;
            case 2:
                list($service, $control, $action) = [$service, $pathInfoArr[0], $pathInfoArr[1]];
                break;
            case 1:
                list($service, $control, $action) = [$service, $control, $pathInfoArr[0]];
                break;
            case 0:
                list($service, $control, $action) = [$service, $control, $action];
                break;
            default:
                throw new BadRequestException('错误的请求');
        }
//        if ($this->pathInfoMode) {
//
//        } else {
//            $service = $this->getKey('s', 'app');
//            $control = $this->getKey('c', 'index');
//            $action = $this->getKey('a', 'index');
//        }
        return array($service, $control, $action);
    }
}
