<?php
declare(strict_types=1);
namespace App\Core;

final class Container
{
    private array $bindings = [];
    private array $instances = [];

    public function set(string $id, callable $factory): void { $this->bindings[$id] = $factory; }
    public function singleton(string $id, callable $factory): void { $this->set($id, fn() => $this->instances[$id] ??= $factory($this)); }
    public function get(string $id): mixed
    {
        if (isset($this->bindings[$id])) return $this->bindings[$id]($this);
        if (!class_exists($id)) throw new \RuntimeException("Service {$id} is not registered");
        $ref = new \ReflectionClass($id);
        $ctor = $ref->getConstructor();
        if (!$ctor) return new $id();
        $args = [];
        foreach ($ctor->getParameters() as $param) {
            $type = $param->getType();
            if ($type instanceof \ReflectionNamedType && !$type->isBuiltin()) { $args[] = $this->get($type->getName()); continue; }
            if ($param->isDefaultValueAvailable()) { $args[] = $param->getDefaultValue(); continue; }
            throw new \RuntimeException("Cannot resolve {$id}::{$param->getName()}");
        }
        return $ref->newInstanceArgs($args);
    }
}
