<?php

namespace App\Core\Container;

use Exception;
use \Psr\Container\ContainerInterface;
use ReflectionClass;
use ReflectionException;
use ReflectionMethod;

/**
 * Class Container
 *
 * @package App\Core\Container
 */
class Container implements ContainerInterface
{
    /**
     * @var null
     */
    protected static $instance = null;

    /**
     * @var array
     */
    protected $instances = [];

    /**
     * @return static|null
     */
    public static function getInstance()
    {
        if (static::$instance) {
            return static::$instance;
        }

        return static::$instance = new static;
    }

    /**
     * @param string      $abstract
     * @param string|null $concrete
     * @param bool        $shared
     */
    public function set(
        string $abstract,
        ?string $concrete = null,
        $shared = false
    ): void {
        if (is_null($concrete)) {
            $concrete = $abstract;
        }

        $this->instances[$abstract] = [
            'concrete'  => $concrete,
            'singleton' => $shared
        ];
    }

    /**
     * @param string      $abstract
     * @param string|null $concrete
     */
    public function singleton(string $abstract, ?string $concrete = null): void
    {
        $this->set($abstract, $concrete, true);
    }

    /**
     * @param string $id
     *
     * @return mixed|object
     * @throws ReflectionException
     */
    public function get($id)
    {
        if (!$this->has($id)) {
            return $this->resolve($id);

        } elseif (!$this->isSingleton($id)) {
            return $this->resolve($this->getConcrete($id));

        } elseif ($this->isInstanceSaved($id)) {
            return $this->getConcrete($id);
        }

        return $this->resolve($this->getConcrete($id), $id, true);
    }

    /**
     * @param string $id
     *
     * @return bool
     */
    public function has($id): bool
    {
        return isset($this->instances[$id]);
    }

    /**
     * @param $id
     *
     * @return bool
     */
    public function isSingleton($id): bool
    {
        return $this->instances[$id]['singleton'];
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function getConcrete($id)
    {
        return $this->instances[$id]['concrete'];
    }

    /**
     * @param string $abstract
     * @param        $instance
     */
    public function saveInstance(string $abstract, $instance): void
    {
        $this->instances[$abstract]['concrete'] = $instance;
    }

    /**
     * @param $id
     *
     * @return bool
     */
    public function isInstanceSaved($id): bool
    {
        return is_object($this->getConcrete($id));
    }

    /**
     * @param string      $concrete
     * @param string|null $abstract
     * @param bool        $singleton
     *
     * @return mixed|object
     * @throws ReflectionException
     */
    public function resolve(
        string $concrete,
        ?string $abstract = null,
        $singleton = false
    ) {
        $reflector = new ReflectionClass($concrete);

        if (!$reflector->isInstantiable()) {
            throw new Exception("Class {$concrete} not instantiable");
        }

        $constructor = $reflector->getConstructor();

        if (is_null($constructor)) {
            if ($singleton) {
                $this->saveInstance($abstract, $reflector->newInstance());

                return $this->getConcrete($abstract);
            }

            return $reflector->newInstance();
        }

        $parameters = $constructor->getParameters();
        $dependencies = $this->getDependencies($parameters);

        if ($singleton) {
            $this->saveInstance(
                $abstract,
                $reflector->newInstanceArgs($dependencies)
            );

            return $this->getConcrete($abstract);
        }

        return $reflector->newInstanceArgs($dependencies);
    }

    /**
     * @param array $parameters
     *
     * @return array
     * @throws ReflectionException
     */
    protected function getDependencies(array $parameters)
    {
        $dependencies = [];

        foreach ($parameters as $parameter) {
            $dependency = $parameter->getClass();

            if (is_null($dependency)) {
                if ($parameter->isDefaultValueAvailable()) {
                    $dependencies []= $parameter->getDefaultValue();
                } else {
                    throw new Exception(
                        "Class dependency: {$parameter->name} can not be resolved"
                    );
                }
            } else {
                $dependencies []= $this->get($dependency->name);
            }
        }

        return $dependencies;
    }

    /**
     * @param string   $class
     * @param string   $method
     * @param array    $parameters
     * @param int|null $userId
     *
     * @return mixed
     * @throws ReflectionException
     */
    public function call(
        string $class,
        string $method,
        array $parameters = [],
        int $userId = null
    ) {
        $concreteClass = $this->get($class);

        if ($userId) {
            $concreteClass->setUserId($userId);
        }

        $reflectMethod = new ReflectionMethod($concreteClass, $method);

        $dependencies = [];

        foreach ($reflectMethod->getParameters() as $parameter) {
            BoundMethod::resolveMethodParameter(
                $this,
                $parameter,
                $dependencies,
                $parameters
            );
        }

        return call_user_func_array([$concreteClass, $method], $dependencies);
    }
}
