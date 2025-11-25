<?php

use Coff\Framework\Core\Application;
use Coff\Framework\Core\Logger;

if (!function_exists('app')) {
    /**
     * Get the available container instance.
     *
     * @param  string|null  $abstract
     * @return mixed|\Coff\Framework\Core\Application
     */
    function app($abstract = null)
    {
        if (is_null($abstract)) {
            return Application::getInstance();
        }

        return Application::getInstance()->make($abstract);
    }
}

if (!function_exists('log_message')) {
    /**
     * Log a message using the framework's logger.
     *
     * @param string $message
     * @param string $level
     * @return void
     */
    function log_message($message, $level = 'info')
    {
        try {
            /** @var Logger $logger */
            $logger = app(Logger::class);
            
            switch (strtolower($level)) {
                case 'error':
                    $logger->error($message);
                    break;
                case 'warning':
                    $logger->warning($message);
                    break;
                case 'debug':
                    $logger->debug($message);
                    break;
                default:
                    $logger->info($message);
                    break;
            }
        } catch (\Exception $e) {
            // Fallback if logger is not available
            error_log("[Fallback Log] $level: $message");
        }
    }
}

