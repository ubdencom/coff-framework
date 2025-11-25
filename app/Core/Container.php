<?php

namespace App\Container;

use ReflectionClass;
use Closure;
use Exception;

class Container {
    protected $bindings = [];

    public function bind($abstract, $concrete) {
        $this->bindings[$abstract] = $concrete;
    }

    public function resolve($abstract) {
        if (!isset($this->bindings[$abstract])) {
            return $this->build($abstract);
        }

        $concrete = $this->bindings[$abstract];

        if ($concrete instanceof Closure) {
            return $concrete($this);
        }

        return $this->build($concrete);
    }

    protected function build($concrete) {
        $reflector = new ReflectionClass($concrete);

        if (!$reflector->isInstantiable()) {
            throw new Exception("Class {$concrete} is not instantiable");
        }

        $constructor = $reflector->getConstructor();

        if (is_null($constructor)) {
            return new $concrete;
        }

        $parameters = $constructor->getParameters();
        $dependencies = array_map(function ($parameter) {
            if ($parameter->getClass()) {
                return $this->resolve($parameter->getClass()->name);
            }
            if ($parameter->isDefaultValueAvailable()) {
                return $parameter->getDefaultValue();
            }
            throw new Exception("Cannot resolve the dependency {$parameter->name}");
        }, $parameters);

        return $reflector->newInstanceArgs($dependencies);
    }
}
?>
