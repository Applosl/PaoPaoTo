<?php
/**
 * Created by PaoPaoTo.
 * User: applosl
 * Date: 2019/1/16
 * Time: 4:42 PM
 */

namespace PaoPaoTo\kernel\Request;

use PaoPaoTo\kernel\Exception\BadRequestException;
use PaoPaoTo\kernel\oneInstance;

class Request extends RequestAbstract implements oneInstance {

    private static $_instance = null; // 单例
    protected $headers = null; // 请求的头部
    protected $body = null; // 请求的body 里面应该是写什么东西
    protected $get = null; // get参数
    protected $post = null; // post 参数
    protected $put = null; // put 参数 扩展支持restful api
    protected $request = null; // request 参数
    protected $method = ''; // 请求方法参数

    private $pathInfoMode = true;

    public $servicePath = ''; // 服务的路由路径

    /**
     * 解析http headers 参数
     */
    protected function parseHttpHeader() {
        $headers = array();
        foreach($_SERVER as $name => $value) {
            if (is_array($value) || substr($name, 0, 5) != 'HTTP_') {
                continue;
            }
            $headerKey = implode('-', array_map('ucwords', explode('_', strtolower(substr($name, 5)))));
            $headers[$headerKey] = $value;
        }
        $this->headers = $headers;

    }

    /**
     * 解析http 普通参数
     */
    protected function parseHttpParams() {
        $this->get = $_GET;
        $this->post = $_POST;
        $this->request = $_REQUEST;
    }

    /**
     * @return static
     */
    public static function getInstance() {
        if (!self::$_instance) {
            self::$_instance = new static();
        }
        return self::$_instance;
    }

    /**
     * Request constructor.
     */
    public function __construct() {
        $this->parseHttpHeader();
        $this->parseHttpParams();
    }

    // TODO 这里是否可以简化获取对象属性的方法 请求的参数 不应该被修改 这里先弄成只读
    public function __call($name, $arguments) {
        // 处理所有get开头的函数 需要判断是否有对应的属性名 异常捕获
    }

    /**
     * 获取所有http request header
     * 考虑处理所有的返回结果的数据类型 最好保持一致
     *
     * @return array|false|null
     */
    public function getHeaders() {
        if (function_exists('getallheaders')) {
            return getallheaders();
        }
        // 没有 getallheaders 方法进行处理
        return $this->headers;
    }

    /**
     * 获取http request head 参数
     *
     * @param string $key header-key
     * @param mixed $default 默认值
     *
     * @return string
     */
    public function getHeader($key, $default = null) {
        if ($this->headers === null) {
            $this->headers = $this->getHeaders();
        }

        return isset($this->headers[$key]) ? $this->headers[$key] : $default;
    }

    /**
     * 返回服务的路由
     * @return array [service,control,action]
     * @throws BadRequestException
     */
    public function getServerPath() {
        // PathInfo 模式开启
        if ($this->pathInfoMode) {
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
        } else {
            $service = $this->getKey('s', 'app');
            $control = $this->getKey('c', 'index');
            $action = $this->getKey('a', 'index');
        }
        return array($service, $control, $action);
    }

    /**
     * 获取请求中的参数
     * @param $key
     * @param mixed $default
     * @return string
     */
    protected function getKey($key, $default = null) {
        return isset($this->get[$key]) ? $this->get[$key] : $default;
    }

    public function getBody() {
        return $this->body;
    }

    public function getParams() {
        return $this->get;
    }

    public function postParams() {
        return $this->post;
    }

    public function putParams() {
        return $this->put;
    }

    public function isAjax() {
    }

    public function isGet() {
        return strtolower($this->method) === 'get';
    }

    public function isPost() {
        return strtolower($this->method) === 'post';
    }

    public function isPut() {
        return strtolower($this->method) === 'put';
    }

    public function isDelete() {
        return strtolower($this->method) === 'delete';
    }

    public function getMethod() {
        return $this->method;
    }
}