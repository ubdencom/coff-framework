<?php

use Coff\Framework\Http\Router;

/** @var Router $router */

$router->mount('/api', function() use ($router) {
    $router->get('/', function() {
        echo json_encode(['status' => 'success', 'message' => 'API is working']);
    });
    
    $router->get('/users', 'App\Controllers\UserController@index');
});

