<?php

namespace App\Modules;

use Illuminate\Support\ServiceProvider;
use File;

class ModuleProvider extends ServiceProvider {

    public function boot() {
        $listModule = array_map('basename', File::directories(__DIR__));
        foreach ($listModule as $module) {
            if (file_exists(__DIR__ . '/' . $module . '/Routes.php')) {
                //include __DIR__ . '/' . $module . '/routes.php';
                $this->loadRoutesFrom(__DIR__ . '/' . $module . '/Routes.php');
            }
            if (is_dir(__DIR__ . '/' . $module . '/Views')) {
                $this->loadViewsFrom(__DIR__ . '/' . $module . '/Views', $module);
            }
        }
    }

    public function register() {
        
    }

}
