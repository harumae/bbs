<?php

// Register an autoloader
$loader = new \Phalcon\Loader();

$loader->registerDirs(array(
    $config->application->controllersDir,
    $config->application->modelsDir,
    $config->application->pluginsDir,
    $config->application->libraryDir,
))->register();
