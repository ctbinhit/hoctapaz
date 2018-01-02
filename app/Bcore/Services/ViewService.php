<?php

namespace App\Bcore\Services;

class ViewService {

    private $_options = [
        'debug' => ['state' => true, 'level' => 'all'],
        'cache' => ['state' => true, 'lifeTime' => 3600],
        'prefix' => 'Types.'
    ];
    private $_controller = null;
    private $_type = null;
    private $_data = null;
    private $_log = null;
    private $_logs = [];

    function __construct($controller = null, $type = null) {
        $this->_controller = $controller != null ? $controller : null;
        $this->_type = $type != null ? $type : null;
        $this->_options = (object) json_decode(json_encode($this->_options));
    }

    public function load_config() {
        $this->_data = $this->arrayToObject(config($this->_options->prefix . $this->_controller));
        return $this;
    }

    public function set_controller($controller_name) {
        $this->_controller = $this->parseConfigName($controller_name);
        return $this;
    }

    public function set_type($type_name) {
        $this->_type = $type_name;
        return $this;
    }

    public function field($field) {
        echo $this->get_option($field);
    }

    // LOG

    public function get_log() {
        return $this->_log;
    }

    public function get_logs() {
        return $this->_logs;
    }

    // ===== PRIVATE FUNCTIONS =========================================================================================

    private function parseConfigName($config_name) {
        if (config()->has($this->_options->prefix . $config_name)) {
            return $config_name;
        }
    }

    private function arrayToObject($array) {
        return (object) json_decode(json_encode($array));
    }

    private function has_options($option) {
        return isset($this->_data->types->{$this->_type}->{$option}) ? true : false;
    }

    private function has_defaultOption($option) {
        return isset($this->_data->default->{$option}) ? true : false;
    }

    private function get_option($option) {
        if ($this->has_options($option)) {
            return $this->_data->types->{$this->_type}->{$option};
        } elseif ($this->has_defaultOption($option)) {
            return $this->_data->default->{$option};
        } else {
            return null;
        }
    }

    private function get_defaultOption($option) {
        
    }

    private function set_log($message, $level, $ex) {
        $this->_log = ['message' => $message, 'level' => $level, 'ex' => $ex];
        $this->set_logs($this->_log);
    }

    private function set_logs($log) {
        $this->_logs[] = $log;
    }

}
