<?php

namespace App\Core\ServiceProviders;

use App\Core\Config;
use App\Core\TemplateEngines\TemplateEngineInterface;
use App\Core\TemplateEngines\TwigDriver;

/**
 * Class TemplateEngineServiceProvider
 *
 * @package App\Core\ServiceProviders
 */
class TemplateEngineServiceProvider extends AbstractServiceProvider
{
    /**
     * @return mixed|void
     * @throws \Exception
     */
    public function register()
    {
        $config = $this->container->get(Config::class);

        $this->container->singleton(
            TemplateEngineInterface::class,
            TwigDriver::class
        );
        $view = $this->container->get(TemplateEngineInterface::class);

        $view->init($config->get('views'));
    }
}
