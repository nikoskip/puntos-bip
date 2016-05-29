<?php

return [

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

    'debug' => env('APP_DEBUG', false),

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

    'url' => env('APP_URL', 'http://localhost'),

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

    'timezone' => 'UTC',

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

    'log' => env('APP_LOG', 'single'),

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
        Illuminate\Pagination\PaginationServiceProvider::class,
        Illuminate\Pipeline\PipelineServiceProvider::class,
        Illuminate\Queue\QueueServiceProvider::class,
        Illuminate\Redis\RedisServiceProvider::class,
        Illuminate\Auth\Passwords\PasswordResetServiceProvider::class,
        Illuminate\Session\SessionServiceProvider::class,
        Illuminate\Translation\TranslationServiceProvider::class,
        Illuminate\Validation\ValidationServiceProvider::class,
        Illuminate\View\ViewServiceProvider::class,

        /*
         * Application Service Providers...
         */
        PuntosBip\Providers\AppServiceProvider::class,
        PuntosBip\Providers\AuthServiceProvider::class,
        PuntosBip\Providers\EventServiceProvider::class,
        PuntosBip\Providers\RouteServiceProvider::class,

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
        'Password' => Illuminate\Support\Facades\Password::class,
        'Queue' => Illuminate\Support\Facades\Queue::class,
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

    ],

    /**
     * URL de la API de datos.gob.cl
     */
    'api_endpoint' => 'http://datos.gob.cl/api',

    /**
     * Timeout por cada llamada a la API en segundos
     */
    'api_timeout' => 5,

    /**
     * Listado de recursos API desde donde se obtienen los Puntos Bip!
     */
    'api_resources' => array(
        'retail' => array(
            'name' => 'Retail',
            'services' => array(\PuntosBip\Models\PuntoBip::SERVICE_CARGA),
            'resource_id' => '2d177f41-08f9-471a-af5c-bc949267f053'
        ),
        'puntos_bip' => array(
            'name' => 'Puntos Bip!',
            'services' => array(\PuntosBip\Models\PuntoBip::SERVICE_CARGA, \PuntosBip\Models\PuntoBip::SERVICE_CONSULTA_SALDO, PuntosBip\Models\PuntoBip::SERVICE_CARGA_REMOTA),
            'resource_id' => 'cbd329c6-9fe6-4dc1-91e3-a99689fd0254'
        ),
        'estaciones_metro' => array(
            'name' => 'Estaciones de Metro',
            'services' => array(\PuntosBip\Models\PuntoBip::SERVICE_CARGA, \PuntosBip\Models\PuntoBip::SERVICE_VENTA_TARJETA),
            'resource_id' => 'ba0cd493-8bec-4806-91b5-4c2b5261f65e'
        ),
/**
 * Al momento de intentar importa los datos de estas fuentes, me di cuenta que no tienen API creada, ya no se utilizan.
 * Si en algún momento se genera una API para acceder a ellos, basta descomentar y actualizar el 'resource_id'.
 */

//        'centros_bip_alto_estandar' => array(
//            'name' => 'Centros Bip! - Alto Estándar',
//            'services' => array(\PuntosBip\Models\PuntoBip::SERVICE_CARGA, \PuntosBip\Models\PuntoBip::SERVICE_VENTA_TARJETA, \PuntosBip\Models\PuntoBip::SERVICE_CONSULTA_SALDO, \PuntosBip\Models\PuntoBip::SERVICE_CARGA_REMOTA, \PuntosBip\Models\PuntoBip::SERVICE_REMPLAZO_TARJETA, \PuntosBip\Models\PuntoBip::SERVICE_RECUPERACION_TARJETA),
//            'resource_id' => 'fef2a0f6-84f8-4a1a-9a64-e2424efdd376'
//        ),
//        'centros_bip_estandar_normal' => array(
//            'name' => 'Centros Bip! - Estándar normal',
//            'services' => array(\PuntosBip\Models\PuntoBip::SERVICE_VENTA_TARJETA, \PuntosBip\Models\PuntoBip::SERVICE_CARGA, \PuntosBip\Models\PuntoBip::SERVICE_CONSULTA_SALDO, \PuntosBip\Models\PuntoBip::SERVICE_CARGA_REMOTA),
//            'resource_id' => '60c16b4e-946f-4ff1-aae2-dc21ce2e941b'
//        ),
    ),

    /**
     * Listado de recursos en archivo desde donde se obtienen los Puntos Bip!
     */
    'file_resources' => array(
        'centros_bip_alto_estandar' => array(
            'name' => 'Centros Bip! - Alto Estándar',
            'services' => array(\PuntosBip\Models\PuntoBip::SERVICE_CARGA, \PuntosBip\Models\PuntoBip::SERVICE_VENTA_TARJETA, \PuntosBip\Models\PuntoBip::SERVICE_CONSULTA_SALDO, \PuntosBip\Models\PuntoBip::SERVICE_CARGA_REMOTA, \PuntosBip\Models\PuntoBip::SERVICE_REMPLAZO_TARJETA, \PuntosBip\Models\PuntoBip::SERVICE_RECUPERACION_TARJETA),
            'resource_file' => 'http://datos.gob.cl/dataset/5993b4cb-869c-4733-a124-7fcdd57bbb05/resource/fef2a0f6-84f8-4a1a-9a64-e2424efdd376/download/pcmav-alto-estandar25052016-oficio-47702013.xls',
        ),
        'centros_bip_estandar_normal' => array(
            'name' => 'Centros Bip! - Estándar normal',
            'services' => array(\PuntosBip\Models\PuntoBip::SERVICE_VENTA_TARJETA, \PuntosBip\Models\PuntoBip::SERVICE_CARGA, \PuntosBip\Models\PuntoBip::SERVICE_CONSULTA_SALDO, \PuntosBip\Models\PuntoBip::SERVICE_CARGA_REMOTA),
            'resource_file' => 'http://datos.gob.cl/dataset/29a758f3-4fe8-4582-afc7-8237b83aaddc/resource/60c16b4e-946f-4ff1-aae2-dc21ce2e941b/download/pcmav-estandar-normal25052016-oficio-47702013.xls'
        )
    )

];
