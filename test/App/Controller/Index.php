<?php

namespace App\Controller;

use PaoPaoTo\kernel\Controller;

/**
 * Class Index
 * 一个测试请求的Demo
 * @package App\Controller
 * @author: applosl <121955907@qq.com> 2019/1/17 4:17 PM
 */
class Index extends Controller {
    public function Index() {
        return "hello world";
    }
}