<?php
/**
 * Created by PaoPaoTo.
 * User: pol
 * Date: 2019/1/16
 * Time: 4:25 PM
 */

namespace PaoPaoTo\kernel;

use PaoPaoTo\kernel\Request\Request;
use PaoPaoTo\kernel\Response\Response;


/**
 * PPT服务对象
 * 一次服务周期所有的功能都 基于这个对象
 * @package PaoPaoTo\kernel
 * @author: applosl
 * DateTime: 2019/1/16 4:33 PM
 */
class PPT {
    private static $_instance = null; // 自生单例
    /**
     * @var Request
     */
    public $request = null; // 请求组件对象
    protected $route = null; // 路由对象
    /**
     * @var Response
     */
    public $response = null; // 响应组件对象
    public $session = null; // session组件(考虑是不是 变为可选配置项)

    /**
     * 由外部文件载入,需要检查其合法性，抑制错误异常
     * 其他组件、中间件、或者扩展插件 都可以由该参数导入
     * @var array
     */
    protected $config = array();

    /**
     * @return self
     */
    public static function getInstance() {
        if (!self::$_instance) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * PPT constructor.
     * @param array $config
     */
    public function __construct($config = array()) {
        // TODO 检查config变量合法性
        $this->config = array_merge($this->config, $config); // merge config
        $this->request = Request::getInstance();
        $this->route = new Route();
        $this->response = Response::getInstance();
    }

    public function parseConfig() {
        // TODO 解析config
    }

    /**
     * 服务响应 这里处理最后的输出结果 模板 异常的处理
     */
    public function serverResponse() {
        // TODO 服务结束响应 处理响应的结果 这里需要全局处理异常的问题 以及连续异常 捕获的情况
        // TODO 异常有框架异常 以及PHP本身的异常导致的 这里需要考虑如何处理
        try {
            $servicePath = $this->request->getServerPath();
            $responseData = $this->route->generateServer($servicePath);
            $this->response->load($responseData);
        } catch (\Exception $e) {
            echo $e->getMessage(); // TODO 异常抛出 服务响应出错
        }
    }
}