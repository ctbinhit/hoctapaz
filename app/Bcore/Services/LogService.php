<?php

namespace App\Bcore\Services;

use Illuminate\Support\Facades\Log;

class LogService {

    function __construct() {
        
    }

    public static function info($class_name, $data) {
        Log::useDailyFiles(storage_path() . '/logs/' . $class_name . '.log');
        Log::info($data);
    }
    
    

}
