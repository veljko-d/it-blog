<?php

namespace App\Core\ServiceProviders;

use App\Models\User\UserModelInterface;
use App\Models\User\UserModel;

/**
 * Class UserServiceProvider
 *
 * @package App\Core\ServiceProviders
 */
class UserServiceProvider extends AbstractServiceProvider
{
    /**
     * @return mixed|void
     */
    public function register()
    {
        $this->container->set(UserModelInterface::class, UserModel::class);
    }
}
