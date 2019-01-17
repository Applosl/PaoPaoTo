<?php
/**
 * Created by PaoPaoTo.
 * User: applosl
 * Date: 2019/1/16
 * Time: 4:42 PM
 */

namespace PaoPaoTo\kernel\Request;


use PaoPaoTo\kernel\oneInstance;

class Request extends RequestAbstract implements RequestParam, oneInstance {

    private static $_instance = null; // 单例
    protected $headers = array();
    protected $body = array();
    protected $get = array();
    protected $post = array();
    protected $put = array();
    protected $request = array();
    protected $method = '';

    protected function parseHttpHeader() {
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->headers['referer'] = $_SERVER['HTTP_REFERER'];
        $this->headers['ip'] = $_SERVER['REMOTE_ADDR'];
    }

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

    public function __construct() {
        $this->parseHttpHeader();
        $this->parseHttpParams();
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