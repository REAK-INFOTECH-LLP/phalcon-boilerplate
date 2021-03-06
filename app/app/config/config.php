<?php

defined('BASE_PATH') || define('BASE_PATH', getenv('BASE_PATH') ?: realpath(dirname(__FILE__) . '/../..'));
defined('APP_PATH') || define('APP_PATH', BASE_PATH . '/app');

return new \Phalcon\Config([
    'database' => [
        'adapter'     => 'Mysql',
        'host'        => 'localhost',
        'username'    => 'root',
        'password'    => 'ashish',
        'dbname'      => 'boilerplate',
        'charset'     => 'utf8',
    ],
    'application' => [
        'appDir'         => APP_PATH . '/',
        'controllersDir' => APP_PATH . '/controllers/',
        'modelsDir'      => APP_PATH . '/models/',
        'migrationsDir'  => APP_PATH . '/migrations/',
        'viewsDir'       => APP_PATH . '/views/',
        'pluginsDir'     => APP_PATH . '/plugins/',
        'libraryDir'     => APP_PATH . '/library/',
        'cacheDir'       => BASE_PATH . '/cache/',
        'baseUri'        => '/',
    ],
    'metadata'  =>  [
        'appUrl'    =>  'http://localhost:8000',
        'fileUploadPath'    =>  '/var/www/html/public/upload',
        'loginFailureLimit' =>  25, // Max threshold values of failed login in [loginFailureTimeLimit] to disable user authentication entirely
        'loginFailureTimeLimit' =>  30, // Time value for failed login threshold (in minutes)
        'sendGridAPIKey'    =>  '',
        'fromEmail' =>  'no-reply@reak.in',
        'fromName'  =>  'REAK INFOTECH LLP'
    ]
]);
