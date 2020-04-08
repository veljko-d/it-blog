<?php

use App\Core\ServiceProviders\CategoryServiceProvider;
use App\Core\ServiceProviders\DatabaseServiceProvider;
use App\Core\ServiceProviders\PostServiceProvider;
use App\Core\ServiceProviders\TagServiceProvider;
use App\Core\ServiceProviders\TemplateEngineServiceProvider;
use App\Core\ServiceProviders\LoggerServiceProvider;
use App\Core\ServiceProviders\UserServiceProvider;

return [
    'name' => getenv('APP_NAME', 'm-frame'),
    'db' => [
        'db_connection' => getenv('DB_CONNECTION', 'mysql'),
        'db_host'       => getenv('DB_HOST', '127.0.0.1'),
        'db_name'       => getenv('DB_DATABASE', 'forge'),
        'user'          => getenv('DB_USERNAME', 'forge'),
        'password'      => getenv('DB_PASSWORD', ''),
    ],
    'views' => getenv('BASE_DIR') . '/resources/views',
    'log' => getenv('BASE_DIR') . '/src/var/log/' . getenv('LOG_FILE'),
    'storage' => getenv('BASE_DIR') . '/public/storage',
    'providers' => [
        DatabaseServiceProvider::class,
        TemplateEngineServiceProvider::class,
        LoggerServiceProvider::class,
        UserServiceProvider::class,
        PostServiceProvider::class,
        CategoryServiceProvider::class,
        TagServiceProvider::class,
    ],
];
