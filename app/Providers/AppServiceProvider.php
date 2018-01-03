<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Schema;
use Cache,
    View;
use SettingModel;

class AppServiceProvider extends ServiceProvider {

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot() {
        Schema::defaultStringLength(191);
    }

    public function eloquent_merge($pObj1, $pObj2) {
        $res;
        foreach ($pObj1 as $k => $v) {
            if (!isset($res[$k])) {
                $res[$k] = $v;
            }
        }
        foreach ($pObj2 as $k => $v) {
            if (!isset($res[$k])) {
                $res[$k] = $v;
            }
        }
        return $res;
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register() {
        //
    }

}
