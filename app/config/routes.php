<?php

$router = new \Phalcon\Mvc\Router();

$router->setDefaults(array(
    'controller'    => 'posts',
    'action'        => 'index',
));

$router->addGet("/posts/:int", array(
    'controller'    => 'posts',
    'action'        => 'index',
    'page'          => 1,
));

$router->addPost("/posts/new/", array(
    'controller'    => 'posts',
    'action'        => 'new',
));

$router->add("/posts/(edit|delete)/:int", array(
    'controller'    => 'posts',
    'action'        => 1,
    'id'            => 2,
));

$router->add("/posts/csv/", array(
    'controller'    => 'posts',
    'action'        => 'csv',
));

$router->addGet("/items/:int", array(
    'controller'    => 'items',
    'action'        => 'index',
    'id'            => 1,
));

$router->addGet("/images/([a-z]+)/:int", array(
    'controller'    => 'images',
    'action'        => 'index',
    'size'          => 1,
    'id'            => 2,
));

$router->addPost("/users/(login|logout)/", array(
    'controller'    => 'users',
    'action'        => '1',
));
