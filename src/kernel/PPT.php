<?php
/**
 * Created by PaoPaoTo.
 * User: pol
 * Date: 2019/1/16
 * Time: 4:25 PM
 */

namespace PaoPaoTo\kernel;


/**
 * Class PPT
 * @package PaoPaoTo\kernel
 * @author: applosl
 * DateTime: 2019/1/16 4:33 PM
 */
class PPT {
    private static $_instance = null; // 单例
    protected $response = null;
    protected $request = null;
    protected $session = null;
    protected $config = array();

    public static function getInstance() {
        if (!self::$_instance) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function __construct($config = array()) {
        $this->config = array_merge($this->config, $config); // merge config
    }

    public function response() {

    }

    public function request() {

    }

    public function config() {

    }

    public function session() {

    }
}