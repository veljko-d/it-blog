<?php

namespace App\Utils;

use App\Exceptions\InvalidPasswordException;

/**
 * Class HashGenerator
 *
 * @package App\Utils
 */
class HashGenerator
{
    /**
     * @param string $password
     * @param string $algorithm
     * @param array  $options
     *
     * @return false|string|null
     */
    public function hash(
        string $password,
        string $algorithm = PASSWORD_DEFAULT,
        array $options = []
    ) {
        return password_hash($password, $algorithm, $options);
    }

    /**
     * @param string $password
     * @param string $hashed
     *
     * @return bool
     * @throws InvalidPasswordException
     */
    public function verifyPassword(string $password, string $hashed): bool
    {
        if (!password_verify($password, $hashed)) {
            throw new InvalidPasswordException("Invalid password!");
        }

        return true;
    }
}
