<?php
/**
 * @author: applosl <121955907@qq.com> 2019/1/17 1:51 PM
 */

namespace PaoPaoTo\kernel;

use PaoPaoTo\kernel\Exception\BadRequestException;


/**
 * Class Route
 * 路由组件类
 *
 * @property Controller $controllerClass 初始的控制类
 * @property null|int $route 当前的路由模式
 *
 * @package PaoPaoTo\kernel
 * @author: applosl <121955907@qq.com> 2019/1/17 1:51 PM
 */
class Route {

    const MODE_GET = 0;
    const MODE_PATH_INFO = 1;

    const MODE_HANDLE_FUN = [
        self::MODE_GET => 'handleGetMode',
        self::MODE_PATH_INFO => 'handlePathInfoMode',
    ];

    // 路由模式配置名称映射表
    const MODE_CONFIG_NAMES = [
        'get' => self::MODE_GET,
        'pathinfo' => self::MODE_PATH_INFO
    ];

    private $serviceName = '';
    private $controlName = '';
    private $actionName = '';

    public $mode = null;

    /**
     * 默认GET模式下GET的参数key
     * @var array
     */
    private $defaultPathGetKey = [
        'service_key' => 's',
        'controller_key' => 'c',
        'action_key' => 'a'
    ];

    protected $controllerClass = null;

    // 构造函数
    public function __construct(array $config = []) {
        $this->checkConfig($config);
    }

    /**
     * 初始化事件 注入时修改再次修改配置文件
     * @param array $config
     */
    public function onInit(array $config = []) {
        $this->checkConfig($config);
    }

    /**
     * 检测配置文件的有效性 如果如果文件异常采取默认配置
     * @param array $config
     */
    private function checkConfig(array $config) {
        if (!isset($config['service']) || empty($config['service']) || !is_string($config['service'])) {
            $this->serviceName = 'App';
        } else {
            $this->serviceName = ucfirst($config['service']);
        }

        if (!isset($config['control']) || empty($config['control']) || !is_string($config['control'])) {
            $this->controlName = 'Index';
        } else {
            $this->controlName = ucfirst($config['control']);
        }

        if (!isset($config['action']) || empty($config['action']) || !is_string($config['action'])) {
            $this->actionName = 'Index';
        } else {
            $this->actionName = ucfirst($config['action']);
        }

        // 检查路由模式
        if (!isset($config['mode']) || empty($config['mode'] || !is_string($config['mode']))) {
            if (null === $this->mode) {
                $this->mode = self::MODE_PATH_INFO; // 没有设置模式的情况下 默认设置PATH_INFO模式
            }
        } else {
            if (isset(self::MODE_CONFIG_NAMES[strtolower($config['mode'])])) {
                $this->mode = self::MODE_CONFIG_NAMES[strtolower($config['mode'])];
            } else {
                if (null === $this->mode) {
                    $this->mode = self::MODE_PATH_INFO; // 没有设置模式的情况下 默认设置PATH_INFO模式
                }
            }
        }

        // 配置GET模式 默认的 键名
        if ($this->checkArrayKey($config, 'service_key')) {
            $this->defaultPathGetKey['service_key'] = $config['service_key'];
        }
        if ($this->checkArrayKey($config, 'controller_key')) {
            $this->defaultPathGetKey['controller_key'] = $config['controller_key'];
        }
        if ($this->checkArrayKey($config, 'action_key')) {
            $this->defaultPathGetKey['action_key'] = $config['action_key'];
        }
    }

    /**
     * 返回服务的路由
     * @return array
     */
    public function getServerPath() {
        return call_user_func([$this, self::MODE_HANDLE_FUN[$this->mode]]);
    }

    /**
     * 处理GET 模式路由
     * @return array
     */
    private function handleGetMode() {
        $service = $this->getGetKey($this->defaultPathGetKey['service_key'], $this->serviceName);
        $control = $this->getGetKey($this->defaultPathGetKey['controller_key'], $this->controlName);
        $action = $this->getGetKey($this->defaultPathGetKey['action_key'], $this->actionName);

        /**
         * 移除这些参数
         */
        foreach($this->defaultPathGetKey as $val) {
            unset($_GET[$val]);
        }
        return array($service, $control, $action);
    }

    /**
     * 处理PATH INFO 模式路由
     * @return array
     * @throws BadRequestException
     */
    private function handlePathInfoMode() {
        // PathInfo 模式开启
        $requestUri = substr($_SERVER['REQUEST_URI'], 0, strpos($_SERVER['REQUEST_URI'], '?'));
        $pathInfoArr = array_values(array_filter(explode('/', $requestUri)));

        $service = $this->serviceName; // 默认服务模块名
        $control = $this->controlName; // 默认控制器名
        $action = $this->actionName; // 默认方法名

        // TODO 看有没有更优雅的方式处理这段程序
        switch (count($pathInfoArr)) {
            case 3:
                list($service, $control, $action) = $pathInfoArr;
                break;
            case 2:
                list($service, $control, $action) = [$service, $pathInfoArr[0], $pathInfoArr[1]];
                break;
            case 1:
                list($service, $control, $action) = [$service, $control, $pathInfoArr[0]];
                break;
            case 0:
                list($service, $control, $action) = [$service, $control, $action];
                break;
            default:
                throw new BadRequestException('错误的请求'); // 3个以上的pathInfo参数暂时不考虑处理
        }
        return array($service, $control, $action);
    }

    /**
     * 获取GET参数里的值
     * @param string $key 键名
     * @param mixed $default
     * @return string|null
     */
    protected function getGetKey(string $key, $default = null) {
        if (isset($_GET[$key]) && !empty($_GET[$key])) {
            return $_GET[$key];
        }
        return $default;
    }

    /**
     * 检查 数组键是否存在 并且是不为空的字符串
     * @param array $arr
     * @param $value
     * @return bool
     */
    protected function checkArrayKey(array $arr, $value) {
        if (isset($arr[$value]) && is_string($value) && !empty($value)) {
            return true;
        }
        return false;
    }
}
