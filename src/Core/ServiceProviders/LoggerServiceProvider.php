<?php

namespace App\Core\ServiceProviders;

use App\Core\Config;
use App\Core\Loggers\LoggerInterface;
use App\Core\Loggers\MonologDriver;

/**
 * Class LoggerServiceProvider
 *
 * @package App\Core\ServiceProviders
 */
class LoggerServiceProvider extends AbstractServiceProvider
{
    /**
     * @return mixed|void
     * @throws \Exception
     */
    public function register()
    {
        $config = $this->container->get(Config::class);

        $this->container->singleton(
            LoggerInterface::class,
            MonologDriver::class
        );
        $log = $this->container->get(LoggerInterface::class);

        $log->init($config->get('name'), $config->get('log'));
    }
}
