<?php

namespace Coff\Framework\Core;

interface MiddlewareInterface
{
    public function handle($request, \Closure $next);
}

