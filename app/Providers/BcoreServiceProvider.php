<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use SettingModel;
use Config,
    Cache;

class BcoreServiceProvider extends ServiceProvider {

    use \App\Bcore\Traits\SettingSupporter;

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot() {

        \Carbon\Carbon::setLocale('vi');

        $SETTING = $this->ss_getSetting();
        if ($SETTING != null) {
            if ($SETTING->timezone != '') {
                config(['app.timezone' => $SETTING->timezone]);
            }
        }

        // ----- MAIL --------------------------------------------------------------------------------------------------
        $MAIL = $this->ss_getSettingAccountName('mail');
        if ($MAIL != null) {
            config(['mail' => [
                    'driver' => $MAIL->driver,
                    'host' => $MAIL->ip_host,
                    'port' => $MAIL->port,
                    'from' => [
                        'address' => $MAIL->from_address,
                        'name' => $MAIL->from_name
                    ],
                    'encryption' => 'tls',
                    'username' => $MAIL->username,
                    'password' => $MAIL->password,
            ]]);
        }
        // ----- END MAIL ----------------------------------------------------------------------------------------------
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register() {
        
    }

}
