<?php

namespace App\Middleware;

class Authentication {
    public function handle() {
        // Oturum başlatma kontrolü
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        
        // Örnek doğrulama kontrolü
        if (!isset($_SESSION['user'])) {
            header('Location: /?path=Login');
            exit;
        }
    }
}
?>
