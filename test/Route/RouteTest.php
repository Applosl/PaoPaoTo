<?php

use PaoPaoTo\kernel\Exception\BadRequestException;
use PaoPaoTo\kernel\Route;
use PHPUnit\Framework\TestCase;

/**
 * Class RouteTest
 * Route测试用例
 * @author: applosl <121955907@qq.com> 2019/1/17 2:34 PM
 */
class RouteTest extends TestCase {
    /**
     * @var Route
     */
    public $Route = null;

    public function setUp() {
        $this->Route = new Route();
    }

    public function routePathProvider() {
        return [
            '默认路由' => [
                ['App', 'index', 'index']
            ]
        ];
    }

    /**
     * @dataProvider routePathProvider
     * @param $generateServer
     */
    public function testRoutePath($generateServer) {
        $this->assertEquals(['App', 'index', 'index'], $generateServer);
    }
}
