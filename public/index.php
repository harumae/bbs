<?php

define('PROJECT_ROOT', dirname(__FILE__) . '/../');
require_once PROJECT_ROOT . '/vendor/autoload.php';

try {
    // Read the configuration
    require_once PROJECT_ROOT . '/app/config/config.php';

    // Register an autoloader
    require_once PROJECT_ROOT . '/app/config/loader.php';

    // Add routing capabilities
    require_once PROJECT_ROOT . '/app/config/routes.php';

    // Setting up a DI
    require_once PROJECT_ROOT . '/app/config/services.php';

    // Handle the request
    $application = new \Phalcon\Mvc\Application($di);
    echo $application->handle()->getContent();

} catch (\Phalcon\Exception $e) {
    echo "PhalconException: ", $e->getMessage();
}
