<?php

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require __DIR__ . '/../vendor/autoload.php';

use Coff\Framework\Core\Application;
use Coff\Framework\Http\Kernel;
use Coff\Framework\Http\Request;

// Uygulamayı Başlat
$app = new Application(dirname(__DIR__));

// Kernel'i Çözümle
$kernel = $app->make(Kernel::class);

// Global Middleware'leri Ekle (İsteğe bağlı)
// $kernel->addMiddleware(App\Middleware\Cors::class);

// İsteği Yakala
$request = Request::capture();

// İsteği İşle
$kernel->handle($request);
