<?php
/**
 * Created by PaoPaoTo.
 * User: applosl
 * Date: 2019/1/16
 * Time: 4:42 PM
 */

namespace PaoPaoTo\kernel\Request;

use PaoPaoTo\kernel\oneInstance;

class Request extends RequestAbstract implements oneInstance {

    private static $_instance = null; // 单例
    protected $headers = array(); // 请求的头部
    protected $body = array(); // 请求的body 里面应该是写什么东西
    protected $get = array(); // get参数
    protected $post = array(); // post 参数
    protected $put = array(); // put 参数 扩展支持restful api
    protected $request = array(); // request 参数
    protected $method = ''; // 请求方法参数

    /**
     * 解析http headers 参数
     */
    protected function parseHttpHeader() {
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->headers['referer'] = $_SERVER['HTTP_REFERER'];
        $this->headers['ip'] = $_SERVER['REMOTE_ADDR'];
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

    public function getHeaders() {
        return $this->headers;
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