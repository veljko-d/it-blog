<?php

namespace App\Core\Request;

use App\Core\Request\Validator\Validator;
use App\Exceptions\NotFoundException;

/**
 * Class Request
 *
 * @package App\Core
 */
class Request
{
    /**
     * @const
     */
    private const GET = 'GET';

    /**
     * @const
     */
    private const POST = 'POST';

    /**
     * @var string
     */
    private $domain;

    /**
     * @var string
     */
    private $path;

    /**
     * @var string
     */
    private $method;

    /**
     * @var QueryFilter
     */
    private $queryParams;

    /**
     * @var Validator
     */
    private $postParams;

    /**
     * @var FilteredMap
     */
    private $cookies;

    /**
     * Request constructor.
     *
     * @throws \ReflectionException
     */
    public function __construct()
    {
        $this->domain = $_SERVER['HTTP_HOST'];
        $this->path = explode('?', $_SERVER['REQUEST_URI'])[0];
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->queryParams = new QueryFilter(new FilteredMap($_GET));
        $files = (new FilesRequest($_FILES))->getFiles();
        $this->postParams = new Validator(new FilteredMap(array_merge($_POST, $files)));
        $this->cookies = new FilteredMap($_COOKIE);
    }

    /**
     * @return string
     */
    public function getDomain(): string
    {
        return $this->domain;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->domain . $this->path;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @return QueryFilter
     */
    public function getQueryParams(): QueryFilter
    {
        return $this->queryParams;
    }

    /**
     * @param array $validationFields
     *
     * @return array
     * @throws NotFoundException
     * @throws \ReflectionException
     */
    public function validate(array $validationFields): array
    {
        return $this->postParams->validate($validationFields);
    }

    /**
     * @return FilteredMap
     */
    public function getCookies(): FilteredMap
    {
        return $this->cookies;
    }

    /**
     * @param string $name
     * @param string $value
     * @param int    $expire
     */
    public function setCookie(string $name, string $value, int $expire = 0): void
    {
        setcookie($name, $value, $expire);
    }

    /**
     * @return bool
     */
    public function isPost(): bool
    {
        return $this->method === self::POST;
    }

    /**
     * @return bool
     */
    public function isGet(): bool
    {
        return $this->method === self::GET;
    }
}
