<?php

namespace App\Core;

use App\Exceptions\HeaderException;

/**
 * Class Redirect
 *
 * @package App\Core
 */
class Redirect
{
    /**
     * @param string $url
     * @param int    $statusCode
     */
    public function location(string $url, int $statusCode = 303)
    {
        try {
            if (headers_sent()) {
                throw new HeaderException('Cannot redirect, headers already sent');
            }

            header('Location: ' . $url, true, $statusCode);
            exit;
        } catch (HeaderException $e) {
            die($e->getMessage());
        }
    }

    /**
     * redirect to home page
     */
    public function home()
    {
        self::location('/');
    }

    /**
     * redirect to login page
     */
    public function login()
    {
        self::location('/login');
    }
}
