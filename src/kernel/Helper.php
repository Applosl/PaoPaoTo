<?php


namespace PaoPaoTo\kernel;


/**
 * Class Helper
 * 助手函数
 * @package PaoPaoTo\kernel
 * @author: applosl <121955907@qq.com> 2019/1/18 3:30 PM
 */
class Helper {

    /**
     * 获取Array的键
     * @param array $array
     * @param string $key
     * @param mixed $default
     * @return mixed|null
     */
    public static function getArrayKey(array &$array, string $key, $default = null) {
        if (isset($array[$key])) {
            return $array[$key];
        }
        return $default;
    }
}
