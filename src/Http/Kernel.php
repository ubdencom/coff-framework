<?php

namespace Coff\Framework\Http;

use Coff\Framework\Core\Application;
use Coff\Framework\Core\MiddlewareInterface;

class Kernel
{
    protected Application $app;
    protected Router $router;
    
    /**
     * Global middleware stack.
     * 
     * @var array
     */
    protected array $middleware = [];

    public function __construct(Application $app, Router $router)
    {
        $this->app = $app;
        $this->router = $router;
    }

    public function handle(Request $request): void
    {
        // Run global middleware
        $this->runMiddleware($request, function ($request) {
            $this->dispatch($request);
        });
    }
    
    protected function dispatch(Request $request): void
    {
        $router = $this->router;
        $basePath = $this->app->basePath();
        
        if (file_exists($basePath . '/routes/web.php')) {
            require $basePath . '/routes/web.php';
        }
        
        if (file_exists($basePath . '/routes/api.php')) {
            require $basePath . '/routes/api.php';
        }
        
        $this->router->run();
    }

    protected function runMiddleware(Request $request, callable $destination): void
    {
        $pipeline = array_reduce(
            array_reverse($this->middleware),
            function ($next, $middlewareClass) {
                return function ($request) use ($next, $middlewareClass) {
                    $middleware = $this->app->make($middlewareClass);
                    if ($middleware instanceof MiddlewareInterface) {
                        return $middleware->handle($request, $next);
                    }
                    // Fallback for legacy middleware that doesn't implement interface
                    // or just simple call
                    return $next($request);
                };
            },
            $destination
        );

        $pipeline($request);
    }
    
    public function addMiddleware(string $middleware): void
    {
        $this->middleware[] = $middleware;
    }
}

