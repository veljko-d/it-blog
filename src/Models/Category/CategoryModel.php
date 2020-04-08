<?php

namespace App\Models\Category;

use App\Domain\Category;
use App\Models\AbstractModel;

/**
 * Class CategoryModel
 *
 * @package App\Models\Category
 */
class CategoryModel extends AbstractModel implements CategoryModelInterface
{
    /**
     * @const
     */
    const CLASSNAME = Category::class;
}
