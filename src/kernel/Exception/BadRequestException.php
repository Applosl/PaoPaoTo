<?php
/**
 * @author: applosl
 * Date: 2019/1/17
 */

namespace PaoPaoTo\kernel\Exception;

use PaoPaoTo\kernel\Response\HeaderStatus;


/**
 * Class BadRequestException
 * 请求异常类
 * @package PaoPaoTo\kernel\Exception
 * @author: applosl <121955907@qq.com> 2019/1/17 11:12 AM
 */
class BadRequestException extends BaseException {
    public function __construct($message = "", $code = 0) {
        parent::__construct($message, $code);
        HeaderStatus::setHttpStatus(404); // TODO 不一定是404 返回码
    }
}
