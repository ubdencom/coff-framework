<?php

namespace Coff\Framework\Auth;

use Coff\Framework\Core\Application;

class AuthManager
{
    protected Application $app;
    protected array $guards = [];

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function guard(string $name = null): AuthInterface
    {
        $name = $name ?: 'web'; // Default to web/session

        if (!isset($this->guards[$name])) {
            $this->guards[$name] = $this->resolve($name);
        }

        return $this->guards[$name];
    }

    protected function resolve(string $name): AuthInterface
    {
        if ($name === 'api') {
            return $this->app->make(TokenGuard::class);
        }

        return $this->app->make(SessionGuard::class);
    }
    
    // Proxy calls to default guard
    public function __call($method, $parameters)
    {
        return $this->guard()->$method(...$parameters);
    }
}

