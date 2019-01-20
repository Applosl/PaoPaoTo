<?php
/**
 * Created by PaoPaoTo.
 * User: applosl
 * Date: 2019/1/16
 * Time: 5:28 PM
 */

defined("TEST_ROOT") || define("TEST_ROOT", __DIR__);
defined("DEBUG_MODE") || define("DEBUG_MODE", true);
defined("APP_ROOT") || define("APP_ROOT", TEST_ROOT . DIRECTORY_SEPARATOR . 'App');
defined("CONFIG_ROOT") || define("CONFIG_ROOT", APP_ROOT . DIRECTORY_SEPARATOR . 'config');

require_once TEST_ROOT . DIRECTORY_SEPARATOR . '../vendor/autoload.php';

