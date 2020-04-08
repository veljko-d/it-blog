<?php

namespace App\Core\ServiceProviders;

use App\Models\Category\CategoryModelInterface;
use App\Models\Category\CategoryModel;

/**
 * Class CategoryServiceProvider
 *
 * @package App\Core\ServiceProviders
 */
class CategoryServiceProvider extends AbstractServiceProvider
{
    /**
     * @return mixed|void
     */
    public function register()
    {
        $this->container->set(CategoryModelInterface::class, CategoryModel::class);
    }
}
