<?php

namespace App\Middleware;

class Logging {
    public function handle() {
        // İstek detaylarını loglama
        log_message("Request: " . $_SERVER['REQUEST_METHOD'] . " " . $_SERVER['REQUEST_URI'], "info");
    }
}
?>
