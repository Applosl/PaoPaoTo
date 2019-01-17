<?php
/**
 * @author: applosl
 * Date: 2019/1/17
 */

namespace PaoPaoTo\kernel\Exception;


/**
 * Class InternalServerException
 * 内部服务异常类
 * @package PaoPaoTo\kernel\Exception
 * @author: applosl <121955907@qq.com> 2019/1/17 11:12 AM
 */
class InternalServerException extends BaseException {
    public function __construct($message = "", $code = 0) {
        parent::__construct($message, $code);
    }
}
