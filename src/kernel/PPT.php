<?php

namespace PaoPaoTo\kernel;

use PaoPaoTo\kernel\Debug\Consume;
use PaoPaoTo\kernel\Exception\BaseException;
use PaoPaoTo\kernel\Request\Request;
use PaoPaoTo\kernel\Response\Response;


/**
 * PPT服务对象
 * 一次服务周期所有的功能都 基于这个对象
 *
 * @property Request $request 请求组件
 * @property Response $response 响应组件
 * @property Route $route 路由组件
 *
 * @property array $componentHitTimes 组件命中次数
 * @property Controller $initController 初始控制器
 * @property string $initAction 初始方法名
 *
 * @package PaoPaoTo\kernel
 * @author: applosl
 * DateTime: 2019/1/16 4:33 PM
 */
class PPT {
    private static $_instance = null; // 自生单例
    public $request = null; // 请求组件对象
    public $route = null; // 路由对象
    public $response = null; // 响应组件对象
    public $session = null; // session组件(考虑是不是 变为可选配置项)

    public $componentPools = []; // 组件注册池
    public $componentHitTimes = []; // 组件命中次数


    private $initController = null; // 初始化controller
    private $initAction = ''; // 初始化方法名


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
     * 设置初始控制器
     * @param Controller $controller
     */
    public function setInitController(Controller $controller) {
        $this->initController = $controller;
    }

    /**
     * 设置初始方法名
     * @param string $actionName
     */
    public function setInitAction(string $actionName = 'Index') {
        $this->initAction = $actionName;
    }

    /**
     * PPT constructor.
     * @param array $config
     */
    public function __construct($config = array()) {
        // TODO 检查config变量合法性
        $this->config = array_merge($this->config, $config); // merge config
        $this->onInit();
    }

    // 初始化事件方法
    public function onInit() {
        $this->request = Request::getInstance();
        $this->route = new Route(); // ?多个路由对象
        $this->response = Response::getInstance();
    }


    public function parseConfig() {
        // TODO 解析config
    }

    /**
     * 获取组件对象
     * @param $key
     * @return mixed
     */
    public function __get($key) {
        if (!isset($this->componentHitTimes[$key])) {
            $this->componentHitTimes[$key] = 0;
        }
        $this->componentHitTimes[$key]++;

        if ($this->componentHitTimes[$key] == 1) {
            $this->componentPools[$key] = $this->activeComponentInit($key);
        }
        return $this->componentHitTimes[$key];
    }

    /**
     * 生成服务
     * @return mixed
     */
    public function generateServer() {
        return $this->initController->init($this->initAction);
    }

    /**
     * 激活组件服务init事件
     * @param $componentPoolsName
     * @return mixed|null|string
     */
    public function activeComponentInit($componentPoolsName) {
        $rs = NULL;

        if ($componentPoolsName instanceOf \Closure) {
            $rs = $componentPoolsName();
        } elseif (is_string($componentPoolsName) && class_exists($componentPoolsName)) {
            $rs = new $componentPoolsName();
            if (is_callable(array($rs, 'onInit'))) {
                call_user_func(array($rs, 'onInit'));
            }
        } else {
            $rs = $componentPoolsName;
        }
        return $rs;
    }


    /**
     * 服务响应 这里处理最后的输出结果 模板 异常的处理
     */
    public function run() {
        // TODO 服务结束响应 处理响应的结果 这里需要全局处理异常的问题 以及连续异常 捕获的情况
        // TODO 异常有框架异常 以及PHP本身的异常导致的 这里需要考虑如何处理
        try {
            $server = ServerFactory::buildServer($this);
            $responseData = $server->generateServer();
            $this->response->load($responseData);
        } catch (BaseException $e) {
            echo $e->getMessage(); // TODO 异常抛出 服务出错
        } catch (\Exception $e) {
            echo $e->getMessage(); // TODO 异常抛出 PHP出错
        }

        if (DEBUG_MODE) {
            // 开启Debug模式
            Consume::setEnd();
            Consume::consumingTime();
        }
    }
}