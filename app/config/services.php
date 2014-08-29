<?php

use Phalcon\Crypt as Crypt,
    Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter,
    Phalcon\DI\FactoryDefault as DI,
    Phalcon\Events\Manager as EventsManager,
    Phalcon\Flash\Session as FlashSession,
    Phalcon\Http\Cookie as Cookie,
    Phalcon\Http\Response\Cookies as Cookies,
    Phalcon\Logger\Adapter\File as Logger,
    Phalcon\Logger\Formatter\Line as Formatter,
    Phalcon\Mvc\Dispatcher as Dispatcher,
    Phalcon\Mvc\Url as Url,
    Phalcon\Mvc\View\Engine\Volt as Volt,
    Phalcon\Mvc\View as View,
    Phalcon\Session\Adapter\Files as Session;


// Create a DI
$di = new DI();

// Setup the application configurations.
$di->set('config', function() use ($config) {
    return $config;
});

// Setup the routing information.
$di->set('router', function() use ($router) {
    return $router;
});

// Set log format.
$formatter = new Formatter();
$formatter->setFormat($config->log->lineFormat);
$formatter->setDateFormat($config->log->dateFormat);

// Setup the logger service
$di->set('logger', function() use ($config, $formatter) {
    $logger = new Logger($config->log->appLog);
    $logger->setFormatter($formatter);
    return $logger;
});

// Setup the dispatch service
$di->set('dispatcher', function() use ($config, $formatter) {
    $logger = new Logger($config->log->dispatchLog);
    $logger->setFormatter($formatter);
    $dispatchListener = new DispatchListener($logger);
    $eventsManager = new EventsManager();
    $eventsManager->attach('dispatch', $dispatchListener);

    $dispatcher = new Dispatcher();

    // Assign the eventsManager to the dispatcher adapter instance.
    $dispatcher->setEventsManager($eventsManager);

    return $dispatcher;
});

// Setup the database service
$di->set('db', function() use ($config, $formatter) {
    $logger = new Logger($config->log->queryLog);
    $logger->setFormatter($formatter);
    $dbListener = new DbListener($logger);
    $eventsManager = new EventsManager();
    $eventsManager->attach('db', $dbListener);

    $dbAdapter = new DbAdapter(array(
        'host'      => $config->database->host,
        'username'  => $config->database->username,
        'password'  => $config->database->password,
        'dbname'    => $config->database->dbname,
        'charset'   => $config->database->charset,
    ));

    // Assign the eventsManager to the db adapter instance.
    $dbAdapter->setEventsManager($eventsManager);

    return $dbAdapter;
});

// Setup the view component
$di->set('view', function() use ($config) {
    $view = new View();
    $view->setViewsDir($config->application->viewsDir);
    $view->registerEngines(array(
        '.volt' => function($view, $di) use ($config) {
            $volt = new Volt($view, $di);
            $volt->setOptions(array(
                'compiledPath'      => $config->volt->path,
                'compiledExtension' => $config->volt->extension,
                'compiledSeparator' => $config->volt->separator,
            ));
            $compiler = $volt->getCompiler();
            $compiler->addFilter('url', 'StringUtils::addUrlAnchor');
            $compiler->addFilter('email', 'StringUtils::addEmailAnchor');
            return $volt;
        }
    ));
    return $view;
});

// Setup a base URI so that all generated URIs include the "bbs" folder
$di->set('url', function() use ($config) {
    $url = new Url();
    $url->setBaseUri($config->application->baseUri);
    return $url;
});

// Start the session the first time when some component request the session service
$di->setShared('session', function() {
    $session = new Session();
    $session->start();
    return $session;
});

// Register the flash service with custom CSS classes
$di->set('flashSession', function() {
    $flash = new FlashSession(array(
        'success'   => 'alert alert-success',
        'notice'    => 'alert alert-info',
        'error'     => 'alert alert-danger',
    ));
    return $flash;
});

// Setup the crypt service
$di->set('crypt', function() {
    $crypt = new Crypt();
    $crypt->setKey('mastersecretkey');
    return $crypt;
});

// Setup the cookie service
$di->set('cookies', function() {
    return new Cookies();
});
