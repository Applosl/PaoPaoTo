<?php
/**
 * Created by PaoPaoTo.
 * User: applosl
 * Date: 2019/1/16
 * Time: 4:45 PM
 */

namespace PaoPaoTo\kernel\Request;


abstract class RequestAbstract {
    protected $headers = [];
    protected $body = [];
    protected $get = [];
    protected $post = [];
    protected $put = [];
    protected $method;

    abstract public function getHeaders();

    abstract public function getBody();

    abstract public function isAjax();

    abstract public function isGet();

    abstract public function isPost();

    abstract public function isPut();

    abstract public function isDelete();

    abstract public function getMethod();

}