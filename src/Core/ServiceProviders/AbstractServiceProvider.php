<?php

namespace App\Core\ServiceProviders;

use App\Core\Container\Container;

/**
 * Class AbstractServiceProvider
 *
 * @package App\Core\ServiceProviders
 */
abstract class AbstractServiceProvider
{
    /**
     * @var Container
     */
    protected $container;

    /**
     * AbstractServiceProvider constructor.
     *
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * @return mixed
     */
    abstract public function register();
}
