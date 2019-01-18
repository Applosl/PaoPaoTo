<?php


namespace PaoPaoTo\kernel\Debug;


/**
 * Class Consume
 * 检查时间、内存消耗
 *
 * @package PaoPaoTo\kernel\Debug
 * @author: applosl <121955907@qq.com> 2019/1/18 3:47 PM
 */
class Consume {
    private static $_instance = null;
    private $startMicroTime = 0;
    private $endMicroTime = 0;

    /**
     * @return Consume
     */
    public static function oneInstance() {
        if (null === self::$_instance) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * 消耗时间
     * @return int
     */
    public static function consumingTime() {
        return round((self::oneInstance()->endMicroTime - self::oneInstance()->startMicroTime) * 1000, 3) . "ms";
    }

    /**
     * 设置开始时间
     */
    public static function setStart() {
        self::oneInstance()->startMicroTime = microtime(true);
    }

    /**
     * 设置结束时间
     */
    public static function setEnd() {
        self::oneInstance()->endMicroTime = microtime(true);
    }

    /**
     * 消耗内存 单位：b
     * @return int
     */
    public static function consumingMemory() {
        if (function_exists('memory_get_usage')) {
            return self::formatMemory(memory_get_usage());
        }
        return 0;
    }

    /**
     * 格式化输出消耗的内存
     * @param int $number
     * @return string
     */
    private static function formatMemory(int $number) {
        $unit = ' b';
        $ret = $number;
        if ($ret > 1024) {
            $ret = round($ret / 1024, 2);
            $unit = ' Kb';
        }
        if ($ret > 1024) {
            $ret = round($ret / 1024, 2);
            $unit = ' Mb';
        }
        return $ret . $unit;
    }
}
