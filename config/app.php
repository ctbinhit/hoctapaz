<?php

return [
    /*
      |--------------------------------------------------------------------------
      |                     ToanNang Framework - Laravel 5.4
      | Edited by Bình Cao | Phone: (+84) 964 247 742 | http://binhcao.com
      | Email: info@binhcao.com | ctbinhit@gmail.com | binhcao.toannang@gmail.com
      | ctbinhit@outlook.com.vn
      | Website: http://toannang.com.vn
      |--------------------------------------------------------------------------
      | This value is the name of your application. This value is used when the
      | framework needs to place the application's name in a notification or
      | any other location as required by the application or its packages.
     */

    'name' => env('APP_NAME', 'TOANNANGCO FRAMEWORK'),
    /*
      |--------------------------------------------------------------------------
      | Application Environment
      |--------------------------------------------------------------------------
      |
      | This value determines the "environment" your application is currently
      | running in. This may determine how you prefer to configure various
      | services your application utilizes. Set this in your ".env" file.
      |
     */
    'env' => env('APP_ENV', 'production'),
    /*
      |--------------------------------------------------------------------------
      | Application Debug Mode
      |--------------------------------------------------------------------------
      |
      | When your application is in debug mode, detailed error messages with
      | stack traces will be shown on every error that occurs within your
      | application. If disabled, a simple generic error page is shown.
      |
     */
    'debug' => env('APP_DEBUG', true),
    /*
      |--------------------------------------------------------------------------
      | Application URL
      |--------------------------------------------------------------------------
      |
      | This URL is used by the console to properly generate URLs when using
      | the Artisan command line tool. You should set this to the root of
      | your application so that it is used when running Artisan tasks.
      |
     */
    'url' => env('APP_URL', 'hoctapaz.com.vn'),
    /*
      |--------------------------------------------------------------------------
      | Application Timezone
      |--------------------------------------------------------------------------
      |
      | Here you may specify the default timezone for your application, which
      | will be used by the PHP date and date-time functions. We have gone
      | ahead and set this to a sensible default for you out of the box.
      |
     */
    'timezone' => 'Asia/Ho_Chi_Minh',
    /*
      |--------------------------------------------------------------------------
      | Application Locale Configuration
      |--------------------------------------------------------------------------
      |
      | The application locale determines the default locale that will be used
      | by the translation service provider. You are free to set this value
      | to any of the locales which will be supported by the application.
      |
     */
    // Ngôn ngữ mặc định
    'locale' => 'en',
    /*
      |--------------------------------------------------------------------------
      | Application Fallback Locale
      |--------------------------------------------------------------------------
      |
      | The fallback locale determines the locale to use when the current one
      | is not available. You may change the value to correspond to any of
      | the language folders that are provided through your application.
      |
     */
    'fallback_locale' => 'en',
    /*
      |--------------------------------------------------------------------------
      | Encryption Key
      |--------------------------------------------------------------------------
      |
      | This key is used by the Illuminate encrypter service and should be set
      | to a random, 32 character string, otherwise these encrypted strings
      | will not be safe. Please do this before deploying an application!
      |
     */
    'key' => env('APP_KEY'),
    'cipher' => 'AES-256-CBC',
    /*
      |--------------------------------------------------------------------------
      | Logging Configuration
      |--------------------------------------------------------------------------
      |
      | Here you may configure the log settings for your application. Out of
      | the box, Laravel uses the Monolog PHP logging library. This gives
      | you a variety of powerful log handlers / formatters to utilize.
      |
      | Available Settings: "single", "daily", "syslog", "errorlog"
      |
     */
    'log' => env('APP_LOG', 'errorlog'),
    'log_level' => env('APP_LOG_LEVEL', 'debug'),
    /*
      |--------------------------------------------------------------------------
      | Autoloaded Service Providers
      |--------------------------------------------------------------------------
      |
      | The service providers listed here will be automatically loaded on the
      | request to your application. Feel free to add your own services to
      | this array to grant expanded functionality to your applications.
      |
     */
    'providers' => [
        App\Modules\ModuleProvider::class,
        /*
         * Laravel Framework Service Providers...
         */
        Illuminate\Auth\AuthServiceProvider::class,
        Illuminate\Broadcasting\BroadcastServiceProvider::class,
        Illuminate\Bus\BusServiceProvider::class,
        Illuminate\Cache\CacheServiceProvider::class,
        Illuminate\Foundation\Providers\ConsoleSupportServiceProvider::class,
        Illuminate\Cookie\CookieServiceProvider::class,
        Illuminate\Database\DatabaseServiceProvider::class,
        Illuminate\Encryption\EncryptionServiceProvider::class,
        Illuminate\Filesystem\FilesystemServiceProvider::class,
        Illuminate\Foundation\Providers\FoundationServiceProvider::class,
        Illuminate\Hashing\HashServiceProvider::class,
        Illuminate\Mail\MailServiceProvider::class,
        Illuminate\Notifications\NotificationServiceProvider::class,
        Illuminate\Pagination\PaginationServiceProvider::class,
        Illuminate\Pipeline\PipelineServiceProvider::class,
        Illuminate\Queue\QueueServiceProvider::class,
        Illuminate\Redis\RedisServiceProvider::class,
        Illuminate\Auth\Passwords\PasswordResetServiceProvider::class,
        Illuminate\Session\SessionServiceProvider::class,
        Illuminate\Translation\TranslationServiceProvider::class,
        Illuminate\Validation\ValidationServiceProvider::class,
        Illuminate\View\ViewServiceProvider::class,
        // Google drive service provider -------------------------------------------------------------------------------
        App\Providers\GoogleDriveServiceProvider::class,
        // Bcore service provicer --------------------------------------------------------------------------------------
        App\Providers\BcoreServiceProvider::class,
        Intervention\Image\ImageServiceProvider::class,
        //PragmaRX\Tracker\Vendor\Laravel\ServiceProvider::class,
        /*
         * Package Service Providers...
         */
        Laravel\Tinker\TinkerServiceProvider::class,
        /*
         * Application Service Providers...
         */
        App\Providers\AppServiceProvider::class,
        App\Providers\AuthServiceProvider::class,
        // Socialite
        Laravel\Socialite\SocialiteServiceProvider::class,
        // PUSHER
        App\Providers\BroadcastServiceProvider::class,
        App\Providers\EventServiceProvider::class,
        App\Providers\RouteServiceProvider::class,
    ],
    /*
      |--------------------------------------------------------------------------
      | Class Aliases
      |--------------------------------------------------------------------------
      |
      | This array of class aliases will be registered when this application
      | is started. However, feel free to register as many as you wish as
      | the aliases are "lazy" loaded so they don't hinder performance.
      |
     */
    'aliases' => [
        'App' => Illuminate\Support\Facades\App::class,
        'Artisan' => Illuminate\Support\Facades\Artisan::class,
        'Auth' => Illuminate\Support\Facades\Auth::class,
        'Blade' => Illuminate\Support\Facades\Blade::class,
        'Broadcast' => Illuminate\Support\Facades\Broadcast::class,
        'Bus' => Illuminate\Support\Facades\Bus::class,
        'Cache' => Illuminate\Support\Facades\Cache::class,
        'Config' => Illuminate\Support\Facades\Config::class,
        'Cookie' => Illuminate\Support\Facades\Cookie::class,
        'Crypt' => Illuminate\Support\Facades\Crypt::class,
        'DB' => Illuminate\Support\Facades\DB::class,
        'Eloquent' => Illuminate\Database\Eloquent\Model::class,
        'Event' => Illuminate\Support\Facades\Event::class,
        'File' => Illuminate\Support\Facades\File::class,
        'Gate' => Illuminate\Support\Facades\Gate::class,
        'Hash' => Illuminate\Support\Facades\Hash::class,
        'Lang' => Illuminate\Support\Facades\Lang::class,
        'Log' => Illuminate\Support\Facades\Log::class,
        'Mail' => Illuminate\Support\Facades\Mail::class,
        'Notification' => Illuminate\Support\Facades\Notification::class,
        'Password' => Illuminate\Support\Facades\Password::class,
        //'Queue' => Illuminate\Support\Facades\Queue::class,
        'Redirect' => Illuminate\Support\Facades\Redirect::class,
        'Redis' => Illuminate\Support\Facades\Redis::class,
        'Request' => Illuminate\Support\Facades\Request::class,
        'Response' => Illuminate\Support\Facades\Response::class,
        'Route' => Illuminate\Support\Facades\Route::class,
        'Schema' => Illuminate\Support\Facades\Schema::class,
        'Session' => Illuminate\Support\Facades\Session::class,
        'Storage' => Illuminate\Support\Facades\Storage::class,
        'URL' => Illuminate\Support\Facades\URL::class,
        'Validator' => Illuminate\Support\Facades\Validator::class,
        'View' => Illuminate\Support\Facades\View::class,
        'Input' => Illuminate\Support\Facades\Input::class,
        'Carbon' => \Carbon\Carbon::class,
        'AdminController' => App\Http\Controllers\AdminController::class,
        // ----- DATABASES MODELS --------------------------------------------------------------------------------------
        'AjaxModel' => App\Models\AjaxModel::class,
        'ArticleModel' => App\Models\ArticleModel::class,
        'ArticleOModel' => App\Models\ArticleOModel::class,
        'ArticleLangModel' => App\Models\ArticleLangModel::class,
        'CityModel' => App\Models\CityModel::class,
        'CategoryModel' => App\Models\CategoryModel::class,
        'CountryModel' => App\Models\CountryModel::class,
        'CategoryLangModel' => App\Models\CategoryLangModel::class,
        'MenuModel' => App\Models\MenuModel::class,
        'StateModel' => App\Models\StateModel::class,
        'SettingModel' => App\Models\SettingModel::class,
        'SettingLangModel' => App\Models\SettingLangModel::class,
        'SettingAccountModel' => App\Models\SettingAccountModel::class,
        'UserModel' => App\Models\UserModel::class,
        'UserPermissionModel' => App\Models\UserPermissionModel::class,
        'PhotoModel' => App\Models\PhotoModel::class,
        'ProductModel' => App\Models\ProductModel::class,
        'ProductLangModel' => App\Models\ProductLangModel::class,
        'LanguageModel' => App\Models\LanguageModel::class,
        'ResponseModel' => App\Models\Response\ResponseModel::class,
        'FileModel' => App\Models\FileModel::class,
        'UserDataModel' => App\Models\UserDataModel::class,
        // ----- 3rd party services ------------------------------------------------------------------------------------
        'Image' => Intervention\Image\Facades\Image::class,
        'Socialite' => Laravel\Socialite\Facades\Socialite::class,
        'Tracker' => PragmaRX\Tracker\Vendor\Laravel\Facade::class,
        // ----- SYSTEM COMPONENTS -------------------------------------------------------------------------------------
        'DocumentState' => \App\Modules\Document\Components\DocumentState::class,
        // ----- BCORE SERVICES ----------------------------------------------------------------------------------------
        'CategoryService' => \App\Bcore\Services\CategoryService::class,
        'PeopleService' => \App\Bcore\Services\PeopleService::class,
        'PDFService' => \App\Bcore\Services\PDFService::class,
        'PayService' => App\Bcore\PayService::class,
        'SeoService' => App\Bcore\Services\SeoService::class,
        'StorageService' => App\Bcore\StorageService::class,
        'LanguageService' => App\Bcore\Services\LanguageService::class,
        'FileService' => App\Bcore\FileService::class,
        'ImageService' => App\Bcore\ImageService::class,
        'UserInterface' => App\Bcore\UserInterface::class,
        'UserPermission' => App\Bcore\UserPermission::class,
        'AuthService' => App\Bcore\AuthService::class,
        'LogService' => App\Bcore\LogService::class,
        'AlertService' => App\Bcore\AlertService::class,
        'MailService' => App\Bcore\Services\MailService::class,
        'UserService' => App\Bcore\Services\UserService::class,
        'UserServiceV2' => App\Bcore\Services\UserServiceV2::class,
        'UserServiceV3' => App\Bcore\Services\UserServiceV3::class,
        'SessionService' => App\Bcore\SessionService::class,
        'OrderService' => \App\Bcore\Services\OrderService::class,
        'AppService' => App\Bcore\Services\AppService::class,
        // 06-11-2017
        'UserDataService' => App\Bcore\Services\UserDataService::class,
        // Platform
        'Bcore' => App\Bcore\Bcore::class,
    // Traits
    ],
];
