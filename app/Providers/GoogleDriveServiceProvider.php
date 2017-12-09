<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Config;
use App\Models\SettingAccountModel;

class GoogleDriveServiceProvider extends ServiceProvider {

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot() {
        \Storage::extend('google', function($app, $config) {
            $GoogleDriveAPIConfig = (object) config::get('Bcore.storage_service.google_drive');
            $client = new \Google_Client();
            $client->setClientId($GoogleDriveAPIConfig->GOOGLE_DRIVE_CLIENT_ID);
            $client->setClientSecret($GoogleDriveAPIConfig->GOOGLE_DRIVE_CLIENT_SECRET);
            $client->refreshToken($GoogleDriveAPIConfig->GOOGLE_DRIVE_REFRESH_TOKEN);
            $service = new \Google_Service_Drive($client);
            $adapter = new \Hypweb\Flysystem\GoogleDrive\GoogleDriveAdapter($service, $GoogleDriveAPIConfig->GOOGLE_DRIVE_FOLDER_ID);
            $res = new \League\Flysystem\Filesystem($adapter);
            return $res;
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register() {
        
    }

}
