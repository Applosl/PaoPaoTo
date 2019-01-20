<?php


namespace PaoPaoTo\kernel;


/**
 * Class ParseConfig
 * 服务参数配置解析器类
 * 用于解决配置的 导入 解析 设置初始化 组件配置的 转移
 *
 * @property null|array $configData 配置数据
 * @property array $components 组件配置数据
 *
 * @package PaoPaoTo\kernel
 * @author: applosl <121955907@qq.com> 2019/1/20 2:25 PM
 */
class ParseConfig {

    private $configData = null; // 配置数据
    private $components = array(); // 组件池

    /**
     * 加载配置文件
     * @param string $configFilename
     */
    public function loadConfig($configFilename = 'main') {
        $configData = include(CONFIG_ROOT . DIRECTORY_SEPARATOR . $configFilename . '.php'); // main config file
        if ($configData && $this->safeCheck($configData)) {
            $this->configData = $this->parseConfig($configData);
        }
    }

    /**
     * 获取配置
     * @return null
     */
    public function getConfig() {
        return $this->configData;
    }

    /**
     * 解析配置
     * @param array $data 配置数据
     * @return array 过滤后的配置数据
     */
    private function parseConfig(array $data) {
        if (!isset($data['app_name']) || empty($data['app_name'])) {
            $data['app_name'] = 'MY-PPT';
        }
        // 加载组件配置
        if (isset($data['components']) && is_array($data['components'])) {
            $this->components = array_merge($this->components, $data['components']);
        }
        return $data;
    }

    /**
     * 安全校验
     * @param mixed $data 配置数据
     * @return bool
     */
    private function safeCheck($data) {
        if (!is_array($data)) {
            $data = $this->configData;
            return false;
        }
        return true;
    }

    // TODO 组件配置注册
    public function componentsConfigRegister() {

    }

}
