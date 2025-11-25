<?php

use Coff\Framework\Http\Router;
use Coff\Framework\Http\Request;

/** @var Router $router */

$router->get('/', function() {
    // Legacy Path Support
    $path = $_GET['path'] ?? 'Home';
    $path = ucfirst($path);
    
    // Check if Legacy Handler exists
    $handlerClass = 'App\\' . $path . '\\Handler';
    
    if (class_exists($handlerClass)) {
        $handler = new $handlerClass();
        
        // Basic Auth Check for Legacy Handlers
        // This mimics the old behavior
        if (!isset($_SESSION['user']) && $path !== 'Login') {
             header('Location: /?path=Login');
             exit;
        }
        
        $handler->handle();
    } else {
        echo "Page not found: " . $path;
    }
});

