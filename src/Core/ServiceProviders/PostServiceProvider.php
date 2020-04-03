<?php

namespace App\Core\ServiceProviders;

use App\Models\Post\PostModelInterface;
use App\Models\Post\PostModel;

/**
 * Class PostServiceProvider
 *
 * @package App\Core\ServiceProviders
 */
class PostServiceProvider extends AbstractServiceProvider
{
    /**
     * @return mixed|void
     */
    public function register()
    {
        $this->container->set(PostModelInterface::class, PostModel::class);
    }
}
