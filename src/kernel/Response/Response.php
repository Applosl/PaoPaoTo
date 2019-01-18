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
    const DATA_TYPE_HTML = 1;
    const DATA_TYPE_JSON = 2;

    const CONTENT_TYPE_MAP = [
        self::DATA_TYPE_HTML => 'text/html',
        self::DATA_TYPE_JSON => 'application/json'
    ];

    private static $_instance = null; // 单例
    public $dataType = self::DATA_TYPE_JSON; // 数据类型 目前仅支持json
    public $charset = 'UTF-8';


    /**
     * 设置contentType
     */
    private function setContentType() {
        header('Content-Type:' . self::CONTENT_TYPE_MAP[$this->dataType] . ';charset=' . $this->charset);
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

    // TODO 加载 从业务应用返回的数据
    public function load($responseData) {
        $this->setContentType();
        if (!is_array($responseData)) {
            $responseData = [
                'code' => 0,
                'data' => $responseData,
                'message' => 'success'
            ];
        }
        JsonFormat::output($responseData); // 目前仅只是输出json格式
    }
}
