<?php

final class ServiceProvider
{
    private $serviceDescriptors = [];
    private $instances = [];

    private const SERVICE_TYPE = 'type';
    private const SERVICE_FACTORY = 'factory';
    private const SERVICE_IS_SINGLETON = 'singleton';

    public function register(string $serviceType, string|callable|null $implementation = null, bool $isSingleton = false): void
    {
        $factory = match (true) {
            is_string($implementation) => function () use ($implementation) {
                return $this->resolve($implementation);
            },
            is_callable($implementation) => $implementation,
            default => function () use ($serviceType) {
                return $this->createInstance($serviceType);
            },
        };
        $this->serviceDescriptors[$serviceType] = [
            self::SERVICE_TYPE => $serviceType,
            self::SERVICE_FACTORY => $factory,
            self::SERVICE_IS_SINGLETON => $isSingleton,
        ];
    }

    public function resolve(string $serviceType): object
    {
        // look up service descriptor
        $sd = $this->serviceDescriptors[$serviceType] ?? null;
        if ($sd === null) {
            //throw new \Exception("Service '{$serviceType}' not registered for dependency injection.");
            http_response_code(404);
            include('views/404.html');
            die();
        }
        // check for existing instance
        $instance = $this->instances[$sd[self::SERVICE_TYPE]] ?? null;
        if ($instance === null) {
            // create instance via factory
            $instance = $sd[self::SERVICE_FACTORY]();
            // store instance when service is singleton
            if ($sd[self::SERVICE_IS_SINGLETON]) {
                $this->instances[$sd[self::SERVICE_TYPE]] = $instance;
            }
        }
        return $instance;
    }

    private function createInstance(string $className): object
    {
        $params = [];
        $ctor = (new \ReflectionClass($className))->getConstructor();
        if ($ctor !== null) {
            foreach ($ctor->getParameters() as $param) {
                $pt = $param->getType();
                if (!$pt instanceof \ReflectionNamedType) {
                    throw new \Exception("Cannot resolve constructor parameter '{$param->getName()}' for class '$className': Parameter does not have named type.");
                }
                $params[] = $this->resolve($pt->getName());
            }
        }
        return new $className(...$params);
    }
}
