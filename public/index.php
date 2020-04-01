<?php

use App\Core\Container\ContainerBuilder;
use App\Core\Router;
use App\Core\Redirect;
use App\Core\Request\Request;

require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

$containerBuilder = new ContainerBuilder();

$router = new Router($containerBuilder->build(), new Redirect());
$response = $router->route(new Request());

echo $response;
