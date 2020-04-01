<?php

namespace App\Models\User;

use App\Models\ModelInterface;
use App\Domain\User;

/**
 * Interface UserModelInterface
 *
 * @package App\Models\User
 */
interface UserModelInterface extends ModelInterface
{
    /**
     * @param User $user
     *
     * @return mixed
     */
    public function store(User $user);

    /**
     * @param string $slug
     * @param string $email
     *
     * @return User
     */
    public function get(string $slug, string $email = ''): User;

    /**
     * @param string $string
     *
     * @return mixed
     */
    public function delete(string $string);
}
