<?php
/**
 * 一个初始化的全局函数库 尽量不要添加太多方法
 * @author : applosl
 * Date: 2019/1/16
 */

namespace PaoPaoTo;

use PaoPaoTo\kernel\Debug\Consume;
use PaoPaoTo\kernel\PPT;

/**
 * 一个生产全局服务对象的函数(单例)
 * @return PPT
 */
function initServer() {
    if(DEBUG_MODE){
        Consume::setStart();
    }
    return PPT::getInstance();
}
