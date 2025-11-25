<?php

namespace Coff\Framework\Core;

use Monolog\Logger as MonologLogger;
use Monolog\Handler\StreamHandler;

class Logger
{
    protected MonologLogger $logger;

    public function __construct(string $logFile)
    {
        $this->logger = new MonologLogger('app');
        $this->logger->pushHandler(new StreamHandler($logFile, MonologLogger::DEBUG));
    }

    public function info(string $message, array $context = []): void
    {
        $this->logger->info($message, $context);
    }

    public function error(string $message, array $context = []): void
    {
        $this->logger->error($message, $context);
    }

    public function debug(string $message, array $context = []): void
    {
        $this->logger->debug($message, $context);
    }

    public function warning(string $message, array $context = []): void
    {
        $this->logger->warning($message, $context);
    }
    
    /**
     * Get the underlying Monolog instance.
     */
    public function getMonolog(): MonologLogger
    {
        return $this->logger;
    }
}

