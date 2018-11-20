<?php
/**
 * Created by Artdevue
 * User: artdevue - gonfig.php
 * Date: 25.02.17
 * Time: 15:33
 * Project: PhalconScelet
 */

$sceme       =
    !empty($_SERVER['REQUEST_SCHEME']) ? $_SERVER['REQUEST_SCHEME'] : (isset($_SERVER['HTTPS']) ? 'https' : 'http');
$server_name = $_SERVER['SERVER_NAME'];

return new \Phalcon\Config([
    'debug'        => env('APP_DEBUG', false),
    // If all your IP and debug is true here, you will see a debugbar. Example local: ::1 or localhost
    'debugbar_api' => [
        //'::1',
        //'localhost'
    ],

    'base_uri'  => env('APP_BASE', ''),
    'site_url'  => env('APP_URL', ''),
    'site_name' => env('APP_NAME', 'Phalcon Blank'),

    'prefix_session' => env('SESSION_PREFIX', 'blank_'),

    'default_module' => 'frontend',
    'modules'        => [
        'frontend' => [
            'dir'           => PROJECT_PATH . 'apps/frontend/',
            'className'     => 'Apps\Frontend\Module',
            'prefix_router' => false,
            'host_name'     => false
        ],
        'backend'  => [
            'dir'           => PROJECT_PATH . 'apps/backend/',
            'className'     => 'Apps\Backend\Module',
            'prefix_router' => 'admin',
            'host_name'     => false
        ],
        'api'      => [
            'dir'           => PROJECT_PATH . 'apps/api/',
            'className'     => 'Apps\Api\Module',
            'prefix_router' => 'api',
            'host_name'     => false
        ]
    ],

    'name_lang_folder' => 'lang',
    'multilang'        => true,
    'default_lang'     => 'en',
    'languages'        => [
        'en' => [
            'name'                => 'English',
            'default_date_format' => 'F j, Y, g:i a'
        ],
        'ua' => [
            'name'                => 'Український',
            'default_date_format' => 'd-m-Y H:i'
        ],
        'ru' => [
            'name'                => 'Русский',
            'default_date_format' => 'd-m-Y H:i'
        ]
    ],
    'database'         => [
        'status'   => env('DB_STATUS', false),
        'adapter'  => env('DB_CONNECTION', 'Mysql'),
        'host'     => env('DB_HOST', 'localhost'),
        'port'     => env('DB_PORT', 3306),
        'username' => env('DB_USERNAME', 'root'),
        'password' => env('DB_PASSWORD','root'),
        'dbname'   => env('DB_DATABASE',''),
        'charset'  => env('DB_CHARSET','UTF8')
    ],

    'application' => [
        'cryptSalt' => env('APP_CRYPTSALT', ''),
        'cacheDir'  => PROJECT_PATH . 'cache/',
        'viewsDir'  => PROJECT_PATH . 'apps/commons/views/',
        'errorLog'  => PROJECT_PATH . 'storage/logs/error.log'
    ],

    'email' => '',
    'mail'  => [
        'driver'     => env('MAIL_DRIVER', 'smtp'), // mail, sendmail, smtp
        'host'       => env('MAIL_HOST', 'smtp.mailtrap.io'),
        'port'       => env('MAIL_PORT', 2525),
        'from'       => [
            'address' => '',
            'name'    => ''
        ],
        'encryption' => env('MAIL_ENCRYPTION', 'tls'),
        'username'   => env('MAIL_USERNAME', ''),
        'password'   => env('MAIL_PASSWORD', ''),
        'sendmail'   => '/usr/sbin/sendmail -bs',
    ],
]);