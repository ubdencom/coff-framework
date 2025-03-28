<?php

namespace App;

abstract class BaseHandler
{
    public function __construct()
    {
        // Eğer oturum başlatılmadıysa başlat
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $this->checkAuthentication();
    }

    private function checkAuthentication()
    {
        if (!isset($_SESSION['user'])) {
            header('Location: /?path=Login');
            exit;
        }
    }

    abstract public function handle();
}
?>
