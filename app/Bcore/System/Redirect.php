<?php

namespace App\Bcore\System;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Request;

class Redirect {

    private $_def_route = null;
    private $_url_redirect = null;

    public static function url($url) {
        if (Request::has('cwu')) {
            return Request::input('cwu');
        } else {
            return route($url);
        }
    }

    public function __construct($route = null) {
        $this->_def_route = $route == null ? ( 'client_index') : ($route);
    }

    public function withUrlIfExists() {
        return $this;
    }

    public function withRouteIfExists($route) {
        $this->_url_redirect = Route::has($route) ? $route : $this->get_default_route();
        return $this;
    }

    public function done() {
        return $this->_url_redirect;
    }

    private function get_default_route() {
        return $this->_def_route == null ? ('client_index') : (Route::has($this->_def_route) ? ($this->_def_route) : ('client_index'));
    }

}
