<?php

namespace App\Actions\Category;

use App\Core\Loggers\LoggerInterface;
use App\Domain\Category;
use App\Models\Category\CategoryModelInterface;

/**
 * Class AbstractCategoryAction
 *
 * @package App\Actions\Category
 */
abstract class AbstractCategoryAction
{
    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @var CategoryModelInterface
     */
    protected $categoryModel;

    /**
     * @var Category
     */
    protected $category;

    /**
     * AbstractCategoryAction constructor.
     *
     * @param LoggerInterface        $logger
     * @param CategoryModelInterface $categoryModel
     * @param Category               $category
     */
    public function __construct(
        LoggerInterface $logger,
        CategoryModelInterface $categoryModel,
        Category $category
    ) {
        $this->logger = $logger;
        $this->categoryModel = $categoryModel;
        $this->category = $category;
    }
}
