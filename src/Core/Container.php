<?php

namespace Coff\Framework\Core;

use Closure;
use ReflectionClass;
use ReflectionException;
use ReflectionParameter;
use Exception;

class Container
{
    /**
     * The container's shared instances.
     *
     * @var array
     */
    protected array $instances = [];

    /**
     * The registered bindings.
     *
     * @var array
     */
    protected array $bindings = [];

    /**
     * Bind a class or interface to the container.
     *
     * @param string $abstract
     * @param mixed $concrete
     * @param bool $shared
     * @return void
     */
    public function bind(string $abstract, $concrete = null, bool $shared = false): void
    {
        if (is_null($concrete)) {
            $concrete = $abstract;
        }

        $this->bindings[$abstract] = compact('concrete', 'shared');
    }

    /**
     * Bind a shared binding (singleton) to the container.
     *
     * @param string $abstract
     * @param mixed $concrete
     * @return void
     */
    public function singleton(string $abstract, $concrete = null): void
    {
        $this->bind($abstract, $concrete, true);
    }

    /**
     * Resolve the given type from the container.
     *
     * @param string $abstract
     * @return mixed
     * @throws Exception
     */
    public function resolve(string $abstract)
    {
        // Return existing singleton instance if available
        if (isset($this->instances[$abstract])) {
            return $this->instances[$abstract];
        }

        $concrete = $this->getConcrete($abstract);

        if ($this->isBuildable($concrete, $abstract)) {
            $object = $this->build($concrete);
        } else {
            $object = $this->make($concrete);
        }

        // Save instance if it is shared
        if (isset($this->bindings[$abstract]) && $this->bindings[$abstract]['shared']) {
            $this->instances[$abstract] = $object;
        }

        return $object;
    }

    /**
     * Get the concrete type for a given abstract.
     *
     * @param string $abstract
     * @return mixed
     */
    protected function getConcrete(string $abstract)
    {
        if (!isset($this->bindings[$abstract])) {
            return $abstract;
        }

        return $this->bindings[$abstract]['concrete'];
    }

    /**
     * Determine if the given concrete is buildable.
     *
     * @param mixed $concrete
     * @param string $abstract
     * @return bool
     */
    protected function isBuildable($concrete, string $abstract): bool
    {
        return $concrete === $abstract || $concrete instanceof Closure;
    }

    /**
     * Instantiate a concrete instance of the given type.
     *
     * @param mixed $concrete
     * @return mixed
     * @throws Exception
     */
    public function build($concrete)
    {
        if ($concrete instanceof Closure) {
            return $concrete($this);
        }

        try {
            $reflector = new ReflectionClass($concrete);
        } catch (ReflectionException $e) {
            throw new Exception("Target class [$concrete] does not exist.", 0, $e);
        }

        if (!$reflector->isInstantiable()) {
            throw new Exception("Target [$concrete] is not instantiable.");
        }

        $constructor = $reflector->getConstructor();

        if (is_null($constructor)) {
            return new $concrete;
        }

        $dependencies = $constructor->getParameters();
        $instances = $this->resolveDependencies($dependencies);

        return $reflector->newInstanceArgs($instances);
    }

    /**
     * Resolve all of the dependencies from the ReflectionParameters.
     *
     * @param array $dependencies
     * @return array
     * @throws Exception
     */
    protected function resolveDependencies(array $dependencies): array
    {
        $results = [];

        foreach ($dependencies as $dependency) {
            $results[] = $this->resolveClass($dependency);
        }

        return $results;
    }

    /**
     * Resolve a class based dependency from the ReflectionParameter.
     *
     * @param ReflectionParameter $parameter
     * @return mixed
     * @throws Exception
     */
    protected function resolveClass(ReflectionParameter $parameter)
    {
        $type = $parameter->getType();

        if (!$type || $type->isBuiltin()) {
            if ($parameter->isDefaultValueAvailable()) {
                return $parameter->getDefaultValue();
            }
            throw new Exception("Unresolvable dependency resolving [$parameter] in class {$parameter->getDeclaringClass()->getName()}");
        }

        return $this->resolve($type->getName());
    }
    
    /**
     * Resolve dependency via make.
     *
     * @param string $abstract
     * @return mixed
     */
    public function make(string $abstract) {
        return $this->resolve($abstract);
    }
    
    /**
     * Get the shared instance of the container.
     */
    protected static ?Container $instance = null;

    public static function getInstance(): Container
    {
        if (is_null(static::$instance)) {
            static::$instance = new static;
        }

        return static::$instance;
    }

    public static function setInstance(Container $container): Container
    {
        return static::$instance = $container;
    }
}

