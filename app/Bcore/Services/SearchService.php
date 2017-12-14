<?php

namespace App\Bcore\Services;

class SearchService {

    private $_params = [];

    function __construct($params_array, $request) {
        foreach ($params_array as $v) {
            if ($request->has($v)) {
                $this->_params = array_add($this->_params, $v, $request->input($v));
            }
        }
    }

    public function generate() {
        return $this->_params;
    }

}
