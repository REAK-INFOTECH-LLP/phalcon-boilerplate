<?php

use Phalcon\Escaper;
use Phalcon\Mvc\View;
use Phalcon\Mvc\View\Engine\Php as PhpEngine;
use Phalcon\Mvc\Url as UrlResolver;
use Phalcon\Mvc\View\Engine\Volt as VoltEngine;
use Phalcon\Mvc\Model\Metadata\Memory as MetaDataAdapter;
use Phalcon\Session\Manager as Manager;
use Phalcon\Session\Adapter\Stream as Stream;
use Phalcon\Flash\Session as Flash;
use Phalcon\Dispatcher;
use Phalcon\Mvc\Dispatcher as MvcDispatcher;
use Phalcon\Events\Event;
use Phalcon\Events\Manager as EventsManager;
use Phalcon\Mvc\Dispatcher\Exception as DispatchException;
use Phalcon\Logger;
use Phalcon\Logger\Adapter\File as FileAdapter;

/**
 * Shared configuration service
 */

$di->setShared('config', function () {
    $config_ini = parse_ini_file("system.ini");
    if($config_ini["environment"] == "production"){
        return include APP_PATH . "/config/config-production.php";
    }
    else {
        return include APP_PATH . "/config/config.php";
    }
});

/**
 * The URL component is used to generate all kind of urls in the application
 */
$di->setShared('url', function () {
    $config = $this->getConfig();

    $url = new UrlResolver();
    $url->setBaseUri($config->application->baseUri);

    return $url;
});

/**
 * Setting up the view component
 */
$di->setShared('view', function () {
    $config = $this->getConfig();

    $view = new View();
    $view->setDI($this);
    $view->setViewsDir($config->application->viewsDir);

    $view->registerEngines([
        '.volt' => function ($view) {
            $config = $this->getConfig();

            $volt = new VoltEngine($view, $this);

            $volt->setOptions([
                'path' => $config->application->cacheDir,
                'separator' => '_'
            ]);

            return $volt;
        },
        '.phtml' => PhpEngine::class

    ]);

    return $view;
});

/**
 * Database connection is created based in the parameters defined in the configuration file
 */
$di->setShared('db', function () {
    $config = $this->getConfig();

    $class = 'Phalcon\Db\Adapter\Pdo\\' . $config->database->adapter;
    $connection = new $class([
        'host'     => $config->database->host,
        'username' => $config->database->username,
        'password' => $config->database->password,
        'dbname'   => $config->database->dbname,
        'charset'  => $config->database->charset
    ]);

    return $connection;
});


/**
 * If the configuration specify the use of metadata adapter use it or use memory otherwise
 */
$di->setShared('modelsMetadata', function () {
    return new MetaDataAdapter();
});

/**
 * Start the session the first time some component request the session service
 */
$session = new Manager();
$files = new Stream([
    'savePath' => '/tmp',
]);
$session->setAdapter($files);
$session->start();

$di->setShared('session', $session);

/**
 * Register the session flash service with the Twitter Bootstrap classes
 */

$flashCSS = [
    'error'   => 'alert alert-danger',
    'success' => 'alert alert-success',
    'notice'  => 'alert alert-info',
    'warning' => 'alert alert-warning'
];

$escaper = new Escaper;
$flash = new Flash($escaper, $session);



$di->setShared(
    "dispatcher",
    function () {
        // Create an EventsManager
        $eventsManager = new EventsManager();

        // Attach a listener
        $eventsManager->attach(
            "dispatch:beforeException",
            function (Event $event, $dispatcher, Exception $exception) {
                // Handle 404 exceptions
                if ($exception instanceof DispatchException) {
                    $dispatcher->forward(
                        [
                            "controller" => "utility",
                            "action"     => "notfound",
                        ]
                    );

                    return false;
                }
            }
        );

        $dispatcher = new MvcDispatcher();

        // Bind the EventsManager to the dispatcher
        $dispatcher->setEventsManager($eventsManager);

        return $dispatcher;
    }
);

$di->setShared('logger',function(){
    $config = $this->getConfig();
    $logger = new FileAdapter($config->application->appDir.'logs/developer.log');

    return $logger;
});
