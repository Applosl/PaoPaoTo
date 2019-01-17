<?php

use PaoPaoTo\kernel\Request\Request;
use PHPUnit\Framework\TestCase;

/**
 * Created by PaoPaoTo.
 * User: applosl
 * Date: 2019/1/16
 * Time: 5:33 PM
 */
class RequestHttpHeaderTest extends TestCase {

    public $request = null;

    public function setUp() {
        $this->request = Request::getInstance();
    }

    public function test
}