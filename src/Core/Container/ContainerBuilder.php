<?php

namespace App\Core\Container;

use App\Core\Config;
use Exception;

/**
 * Class ContainerBuilder
 *
 * @package App\Core\Container
 */
class ContainerBuilder
{
    /**
     * @return Container
     * @throws Exception
     */
    public function build(): Container
    {
        $container = Container::getInstance();

        $container->singleton(Config::class);
        $config = $container->get(Config::class);
        $providers = $config->get('providers');

        foreach ($providers as $providerClass) {
            $provider = new $providerClass($container);
            $provider->register();
        }

        return $container;
    }
}
