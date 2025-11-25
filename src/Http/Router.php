<?php

namespace Coff\Framework\Http;

use Bramus\Router\Router as BramusRouter;

class Router
{
    protected BramusRouter $router;

    public function __construct()
    {
        $this->router = new BramusRouter();
    }

    public function get(string $pattern, $fn): void
    {
        $this->router->get($pattern, $fn);
    }

    public function post(string $pattern, $fn): void
    {
        $this->router->post($pattern, $fn);
    }

    public function put(string $pattern, $fn): void
    {
        $this->router->put($pattern, $fn);
    }

    public function delete(string $pattern, $fn): void
    {
        $this->router->delete($pattern, $fn);
    }

    public function mount(string $baseRoute, $fn): void
    {
        $this->router->mount($baseRoute, $fn);
    }

    public function run(): void
    {
        $this->router->run();
    }
    
    /**
     * Get the underlying router instance.
     * 
     * @return BramusRouter
     */
    public function getBramusRouter(): BramusRouter
    {
        return $this->router;
    }
}

