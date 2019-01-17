<?php
/**
 * @author: applosl
 * Date: 2019/1/17
 */

namespace PaoPaoTo\kernel\Exception;
use \Throwable;


/**
 * Class BaseException
 * 服务基础异常类
 * @package PaoPaoTo\kernel\Exception
 * @author: applosl <121955907@qq.com> 2019/1/17 11:12 AM
 */
class BaseException extends \Exception {
    public function __construct($message = "", $code = 0, Throwable $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}