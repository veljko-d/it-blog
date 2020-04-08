<?php

namespace App\Core\ServiceProviders;

use App\Models\Tag\TagModelInterface;
use App\Models\Tag\TagModel;

/**
 * Class TagServiceProvider
 *
 * @package App\Core\ServiceProviders
 */
class TagServiceProvider extends AbstractServiceProvider
{
    /**
     * @return mixed|void
     */
    public function register()
    {
        $this->container->set(TagModelInterface::class, TagModel::class);
    }
}
