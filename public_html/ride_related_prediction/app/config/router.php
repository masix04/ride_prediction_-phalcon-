<?php

$router = $di->getRouter();

// Define your routes here

$router->add(
    '/user/signup',
    [
        'controller' => 'signup',
        'action' => 'register'
    ]
);

$router->add(
    '/user/login',
    [
        'controller' => 'user',
        'action' => 'index'
    ]
);


$router->handle();
