<?php


namespace PaoPaoTo\kernel\Response;


/**
 * Class JsonFormat
 * Json格式响应返回
 * @package PaoPaoTo\kernel\Response
 * @author: applosl <121955907@qq.com> 2019/1/18 9:06 AM
 */
class JsonFormat {

    /**
     * Json格式输出
     * @param array $data
     */
    public static function output(array $data) {
        echo json_encode($data);
    }
}
