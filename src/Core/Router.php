<?php

namespace App\Core;

use App\Core\Container\Container;
use App\Core\Request\Request;
use App\Controllers\NotFoundController;

/**
 * Class Router
 *
 * @package App\Core
 */
class Router
{
    /**
     * @var Container
     */
    public $container;

    /**
     * @var mixed
     */
    private $routeMap;

    /**
     * @var Redirect
     */
    private $redirect;

    /**
     * @var array
     */
    private static $regexPatterns = [
        'number' => '\d+',
        'string' => '[\w\'-]+',
    ];

    /**
     * Router constructor.
     *
     * @param Container $container
     * @param Redirect  $redirect
     */
    public function __construct(Container $container, Redirect $redirect)
    {
        $this->container = $container;
        $this->routeMap = require __DIR__ . '/../../routes/web.php';
        $this->redirect = $redirect;
    }

    /**
     * @param Request $request
     *
     * @return mixed
     * @throws \ReflectionException
     */
    public function route(Request $request)
    {
        $path = $request->getPath();

        foreach ($this->routeMap as $key => $info) {
            $split = explode('::', $key, 2);
            $route = $split[1];
            $mapMethod = strtoupper($split[0]);

            $regexRoute = $this->getRegexRoute($route, $info);

            if (
                preg_match("@^/$regexRoute$@", $path)
                && $request->getMethod() === $mapMethod
            ) {
                return $this->executeController($route, $path, $info, $request);
            }
        }

        $notFoundController = $this->container->get(NotFoundController::class);

        return $notFoundController->index();
    }

    /**
     * @param string $route
     * @param array  $info
     *
     * @return string
     */
    private function getRegexRoute(string $route, array $info): string
    {
        if (isset($info['params'])) {
            foreach ($info['params'] as $name => $type) {
                $route = str_replace(
                    ':' . $name, self::$regexPatterns[$type], $route
                );
            }
        }

        return $route;
    }

    /**
     * @param string $route
     * @param string $path
     *
     * @return array
     */
    private function extractParams(string $route, string $path): array
    {
        $params = [];

        $pathParts = explode('/', $path);
        $routeParts = explode('/', $route);

        foreach ($routeParts as $key => $routePart) {
            if (strpos($routePart, ':') === 0) {
                $name = substr($routePart, 1);
                $params[$name] = $pathParts[$key+1];
            }
        }

        return $params;
    }

    /**
     * @param string  $route
     * @param string  $path
     * @param array   $info
     * @param Request $request
     *
     * @return mixed
     * @throws \ReflectionException
     */
    private function executeController(
        string $route,
        string $path,
        array $info,
        Request $request
    ) {
        $params = $this->extractParams($route, $path);
        $userId = $this->checkLogin($info, $request) ?? null;

        return $this->container->call(
            $info['controller'],
            $info['method'],
            $params,
            $userId
        );
    }

    /**
     * @param array   $info
     * @param Request $request
     *
     * @return bool|mixed|null
     */
    private function checkLogin(array $info, Request $request)
    {
        if (isset($info['login']) && $info['login']) {
            if ($request->getCookies()->has('user_id')) {
                return $request->getCookies()->get('user_id');
            }

            $this->redirect->login();
        }
    }
}
