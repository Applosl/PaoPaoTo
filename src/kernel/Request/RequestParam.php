<?php
/**
 * Created by PaoPaoTo.
 * User: applosl
 * Date: 2019/1/16
 * Time: 4:42 PM
 */

namespace PaoPaoTo\kernel\Request;


interface RequestParam {

    public function getHeaders();

    public function getBody();

    public function isAjax();

    public function isGet();

    public function isPost();

    public function isPut();

    public function isDelete();

    public function getMethod();

}