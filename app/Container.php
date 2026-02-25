<?php

declare(strict_types=1);

namespace App;

use Psr\Container\ContainerInterface;
use App\Exceptions\Containers\NotFoundException;
use ReflectionIntersectionType;
use ReflectionNamedType;
use ReflectionUnionType;

use function PHPUnit\Framework\isNull;

class Container implements ContainerInterface
{
    /**
     * @var array<string,callable>
     * An associative array holds class name , and a callable that returns an instance of that class
     */
    private array $entries;

    public function __construct()
    {
        $this->entries = [];
    }
    public function get(string $id)
    {
        if ($this->has($id)) {
            if (is_callable($this->entries[$id])) {
                return $this->entries[$id]();
            }
            $id = $this->entries[$id];
        }
        return $this->resolve($id);
    }

    public function has(string $id): bool
    {
        return isset($this->entries[$id]);
    }

    public function set(string $id, callable|string $concrete)
    {
        $this->entries[$id] = $concrete;
    }

    public function resolve(string $id)
    {

        $reflectionClass = new \ReflectionClass($id);

        if (!$reflectionClass->isInstantiable()) {
            throw new \Exception("Class $id is not instantiable.");
        }
        $constructor = $reflectionClass->getConstructor();

        if (is_null($constructor)) {
            return new $id();
        }
        $constructorParameters = $constructor->getParameters();
        if (is_null($constructorParameters)) {
            return new $id();
        }

        $dependencies = array_map(function (\ReflectionParameter $parameter) {
            $parameterName = $parameter->getName();
            $parameterType = $parameter->gettype();
            if ($parameterType->isBuiltin()) {
                throw new \Exception("Built in paramater $parameterName of type $parameterType is needed");
            }
            if ($parameterType instanceof ReflectionIntersectionType || $parameterType instanceof ReflectionUnionType) {
                throw new \Exception("paramater $parameterName is an union or intersection type");
            }
            if (is_null($parameterType)) {
                throw new \Exception("paramater $parameterName not type hinted");
            }
            return $this->get($parameterType->getName());
        }, $constructorParameters);
        return $reflectionClass->newInstanceArgs($dependencies);
    }
}
