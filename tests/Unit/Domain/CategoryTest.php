<?php

namespace Tests\Unit\Domain;

use App\Domain\Category;
use ReflectionClass;
use Tests\AbstractTestCase;

/**
 * Class CategoryTest
 *
 * @package Tests\Unit\Domain
 */
class CategoryTest extends AbstractTestCase
{
    /**
     * @test
     */
    public function testClassInstance()
    {
        $category = new Category();

        $this->assertInstanceOf(
            Category::class,
            $category,
            'Created object is not the instance of the User class.'
        );
    }

    /**
     * @throws \ReflectionException
     */
    public function testGetData()
    {
        $category = $this->createCategory();

        $this->assertSame(9, $category->getId(), 'ID is incorrect.');

        $this->assertSame('News', $category->getName(), 'Name is incorrect.');

        $this->assertSame('news', $category->getSlug(), 'Slug is incorrect.');

        $this->assertSame(
            2,
            $category->getCategoryId(),
            'Category ID is incorrect'
        );
    }

    /**
     * @throws \ReflectionException
     */
    public function setAndGetSubCategories()
    {
        $category = $this->createCategory();

        $subCategories = ['one', 'two', 'three'];

        $category->setCategories($subCategories);

        $this->assertSame(
            $subCategories,
            $category->getCategories(),
            'Sub Categories are incorrect'
        );
    }

    /**
     * @return Category
     * @throws \ReflectionException
     */
    private function createCategory(): Category
    {
        $category = new Category();

        $reflectionClass = new ReflectionClass(Category::class);

        $properties = [
            'id'          => 9,
            'name'        => 'News',
            'slug'        => 'news',
            'category_id' => 2,
        ];

        foreach ($properties as $key => $value) {
            $property = $reflectionClass->getProperty($key);
            $property->setAccessible(true);
            $property->setValue($category, $value);
        }

        return $category;
    }
}
