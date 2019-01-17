<?php


namespace PaoPaoTo\kernel\Response;


use PaoPaoTo\kernel\oneInstance;

/**
 * Class Response
 * 响应组件类
 * @package PaoPaoTo\kernel\Response
 * @author: applosl <121955907@qq.com> 2019/1/17 5:40 PM
 */
class Response implements oneInstance {
    private static $_instance = null; // 单例
    public $dataType = ''; // 数据类型

    /**
     * @return static
     */
    public static function getInstance() {
        if (!self::$_instance) {
            self::$_instance = new static();
        }
        return self::$_instance;
    }

    // TODO 加载 从业务应用返回的数据
    public function load($responseData) {

    }
}
