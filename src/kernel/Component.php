<?php


namespace PaoPaoTo\kernel;


/**
 * Class Component
 * 组件基础类
 * @package PaoPaoTo\kernel
 * @author: applosl <121955907@qq.com> 2019/1/20 3:37 PM
 */
abstract class Component {

    public $componentId; // 组件ID

    /**
     * 对象初始化事件
     */
    abstract public function onInit();

    /**
     * 加载数据配置 给 属性
     * @param array $data
     */
    public function onSetConfig(array $data) {
        foreach($data as $name => $value) {
            if (property_exists(static::class, $name)) {
                $this->$name = $value;
            }
        }

    }
}
