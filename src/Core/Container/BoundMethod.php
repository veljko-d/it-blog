<?php

namespace App\Core\Container;

use Exception;

/**
 * Class BoundMethod
 *
 * @package App\Core\Container
 */
class BoundMethod
{
    /**
     * @param Container $container
     * @param           $parameter
     * @param array     $dependencies
     * @param array     $parameters
     *
     * @throws Exception
     */
    public static function resolveMethodParameter(
        Container $container,
        $parameter,
        array &$dependencies,
        array $parameters = []
    ) {
        if (array_key_exists($parameter->name, $parameters)) {
            $dependencies []= $parameters[$parameter->name];

        } elseif ($parameter->getClass()) {
            $dependencies []= $container->get($parameter->getClass()->name);

        } elseif ($parameter->isDefaultValueAvailable()) {
            $dependencies []= $parameter->getDefaultValue();

        } else {
            throw new Exception("Dependency {$parameter->name} can not be resolved");
        }
    }
}
