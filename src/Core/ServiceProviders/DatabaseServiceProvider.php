<?php

namespace App\Core\ServiceProviders;

use App\Core\Config;
use App\Core\Db\DbInterface;
use App\Core\Db\Mysql\MysqlDriver;

/**
 * Class DatabaseServiceProvider
 *
 * @package App\Core\ServiceProviders
 */
class DatabaseServiceProvider extends AbstractServiceProvider
{
    /**
     * @return mixed|void
     * @throws \ReflectionException
     */
    public function register()
    {
        $config = $this->container->get(Config::class);

        $this->container->singleton(DbInterface::class, MysqlDriver::class);
        $db = $this->container->get(DbInterface::class);

        $db->init($config->get('db'));
    }
}
