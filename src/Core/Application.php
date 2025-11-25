<?php

namespace Coff\Framework\Core;

use Coff\Framework\Core\Logger;

class Application extends Container
{
    /**
     * The base path for the application.
     *
     * @var string
     */
    protected string $basePath;

    /**
     * Create a new application instance.
     *
     * @param string|null $basePath
     */
    public function __construct(?string $basePath = null)
    {
        if ($basePath) {
            $this->setBasePath($basePath);
        }

        $this->registerBaseBindings();
        $this->registerLogger();
        $this->bootstrap();
    }

    /**
     * Register the logger instance.
     *
     * @return void
     */
    protected function registerLogger(): void
    {
        $this->singleton(Logger::class, function () {
            return new Logger($this->basePath('logs/debug.log'));
        });
        
        // Alias for easier access
        $this->bind('logger', Logger::class);
    }

    /**
     * Set the base path for the application.
     *
     * @param string $basePath
     * @return $this
     */
    public function setBasePath(string $basePath): self
    {
        $this->basePath = rtrim($basePath, '\/');
        return $this;
    }

    /**
     * Get the base path of the installation.
     *
     * @param string $path
     * @return string
     */
    public function basePath(string $path = ''): string
    {
        return $this->basePath . ($path ? DIRECTORY_SEPARATOR . $path : $path);
    }

    /**
     * Register the basic bindings into the container.
     *
     * @return void
     */
    protected function registerBaseBindings(): void
    {
        static::setInstance($this);
        $this->singleton('app', $this);
        $this->singleton(Container::class, $this);
    }

    /**
     * Bootstrap the application.
     *
     * @return void
     */
    protected function bootstrap(): void
    {
        // Load environment variables if needed (simple implementation)
        $this->loadEnvironment();
    }

    /**
     * Load environment variables from .env file.
     */
    protected function loadEnvironment(): void
    {
        if (file_exists($this->basePath . '/.env')) {
            $lines = file($this->basePath . '/.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            foreach ($lines as $line) {
                if (strpos(trim($line), '#') === 0) {
                    continue;
                }
                list($name, $value) = explode('=', $line, 2);
                $name = trim($name);
                $value = trim($value);
                if (!array_key_exists($name, $_SERVER) && !array_key_exists($name, $_ENV)) {
                    putenv(sprintf('%s=%s', $name, $value));
                    $_ENV[$name] = $value;
                    $_SERVER[$name] = $value;
                }
            }
        }
    }
}

