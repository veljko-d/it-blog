<?php

namespace App\Core;

/**
 * Class SessionManager
 *
 * @package App\Core
 */
class SessionManager
{
    /**
     * start session
     */
    public function startSession(): void
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
    }

    /**
     * @param string $name
     * @param        $value
     */
    public function set(string $name, $value): void
    {
        $_SESSION[$name] = $value;
    }

    /**
     * @param string $name
     *
     * @return mixed
     */
    public function get(string $name)
    {
        if (isset($_SESSION[$name])) {
            return $_SESSION[$name];
        }
    }

    /**
     * @param string $name
     *
     * @return bool
     */
    public function has(string $name): bool
    {
        return isset($_SESSION[$name]);
    }

    /**
     * @param string $name
     */
    public function unset(string $name): void
    {
        unset($_SESSION[$name]);
    }
}
