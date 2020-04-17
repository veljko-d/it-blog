<?php

namespace App\Actions\Category;

/**
 * Class GetParentCategoriesAction
 *
 * @package App\Actions\Category
 */
class GetParentCategoriesAction extends AbstractCategoryAction
{
    /**
     * @return array
     */
    public function execute()
    {
        return ['categories' => $this->categoryModel->getParentCategories()];
    }
}
