<?php

namespace Tests\Unit\Models;

use App\Exceptions\DbException;
use App\Models\Category\CategoryModel;
use Tests\Unit\ModelTestCase;

/**
 * Class CategoryModelTest
 *
 * @package Tests\Unit\Models
 */
class CategoryModelTest extends ModelTestCase
{
    /**
     * @var array
     */
    protected $tables = [
        'categories',
        'users',
        'posts',
    ];

    /**
     * @var CategoryModel
     */
    protected $categoryModel;

    /**
     * @setUp
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->categoryModel = new CategoryModel($this->db);
    }

    /**
     * @throws DbException
     */
    public function testGetParentCategoriesWithSubcategories()
    {
        $parentId = $this->insertCategory();
        $this->insertSubcategories($parentId);

        $parents = $this->categoryModel->getParentCategories();
        $parentId = ($parents[0])->getId();

        $this->assertCount(
            1,
            $parents,
            "Array size not as expected."
        );

        $children = $this->categoryModel->getSubcategoriesByParent($parentId);

        $this->assertCount(
            3,
            $children,
            "Array size not as expected."
        );
    }

    /**
     * @throws DbException
     */
    public function testGetPostsByCategory()
    {
        $categoryId = $this->insertCategory();
        $userId = $this->insertUser($this->buildUser());

        $post = $this->buildPost($categoryId, $userId);
        $this->insertPost($post);

        $params = ['slug' => 'web', 'page' => 1, 'length' => 5];

        $posts = $this->categoryModel->getPostsByCategory($params);

        $this->assertCount(
            1,
            $posts,
            "Array size not as expected."
        );
    }
}
