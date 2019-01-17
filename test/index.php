<?php
/**
 * 这是一个模拟服务测试的入口文件
 * Nginx测试的配置文件在 同目录下的TestServerForNginx.conf里
 * @author: applosl <121955907@qq.com> 2019/1/17 11:40 AM
 */

require_once __DIR__ . DIRECTORY_SEPARATOR . 'bootstrap.php';

$server = \PaoPaoTo\initServer(); // 初始化服务对象
$server->serverResponse(); // 响应结果
