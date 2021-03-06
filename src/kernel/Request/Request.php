<?php
/**
 * Created by PaoPaoTo.
 * User: applosl
 * Date: 2019/1/16
 * Time: 4:42 PM
 */

namespace PaoPaoTo\kernel\Request;

use PaoPaoTo\kernel\oneInstance;

/**
 * Class Request
 * @package PaoPaoTo\kernel\Request
 * @author: applosl <121955907@qq.com> 2019/1/18 3:54 PM
 */
class Request extends RequestAbstract implements oneInstance {

    private static $_instance = null; // 单例
    protected $headers = null; // 请求的头部
    protected $body = null; // 请求的body 里面应该是写什么东西
    protected $post = null; // post 参数
    protected $put = null; // put 参数 扩展支持restful api
    protected $request = null; // request 参数
    protected $method = ''; // 请求方法参数

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
     * 解析 http method 参数
     */
    protected function parseHttpMethod() {
        $this->method = strtolower($_SERVER['REQUEST_METHOD'] ?? '');
    }

    /**
     * 解析http 普通参数
     */
    protected function parseHttpParams() {
        $this->get = &$_GET;
        $this->post = &$_POST;
        $this->request = &$_REQUEST;
        // TODO 未来需要考虑接受 PUT 和 PATCH DELETE等 http1.1的方法
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
        $this->parseHttpMethod();
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