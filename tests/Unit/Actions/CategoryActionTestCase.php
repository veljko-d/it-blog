<?php

namespace Tests\Unit\Actions;

use App\Core\Loggers\MonologDriver;
use App\Domain\Category;
use App\Models\Category\CategoryModel;
use PHPUnit\Framework\MockObject\MockObject;
use Tests\AbstractTestCase;

/**
 * Class CategoryActionTestCase
 *
 * @package Tests\Unit\Actions
 */
class CategoryActionTestCase extends AbstractTestCase
{
    /**
     * @var MonologDriver|MockObject
     */
    protected $logger;

    /**
     * @var CategoryModel|MockObject
     */
    protected $categoryModel;

    /**
     * @var Category|MockObject
     */
    protected $category;

    /**
     * @setUp
     */
    public function setUp(): void
    {
        $this->logger = $this->createMock(MonologDriver::class);
        $this->categoryModel = $this->createMock(CategoryModel::class);
        $this->category = $this->createMock(Category::class);
    }
}
