<?php

namespace Tests\Unit\Domain;

use App\Domain\Image;
use Tests\AbstractTestCase;

/**
 * Class ImageTest
 *
 * @package Tests\Unit\Domain
 */
class ImageTest extends AbstractTestCase
{
    /**
     * @test
     */
    public function testClassInstance()
    {
        $image = new Image();

        $this->assertInstanceOf(
            Image::class,
            $image,
            'Created object is not the instance of the Image class.'
        );
    }

    public function testCreateAndGetData()
    {
        $image = $this->buildImage();

        $this->assertSame(
            'image-name',
            $image->getName(),
            'Name is incorrect.'
        );

        $this->assertSame(
            'png',
            $image->getExt(),
            'Extension is incorrect.'
        );

        $this->assertSame(
            '/path/to/image',
            $image->getPath(),
            'Path is incorrect.'
        );

        $this->assertSame(
            1000,
            $image->getSize(),
            'Size is incorrect.'
        );
    }

    /**
     * @test
     */
    public function testSetPostId()
    {
        $image = $this->buildImage();

        $image->setPostId(15);

        $this->assertEquals(
            15,
            $image->getPostId(),
            'Post ID is incorrect.'
        );
    }

    /**
     * @test
     */
    public function testSetUserId()
    {
        $image = $this->buildImage();

        $image->setUserId(10);

        $this->assertEquals(
            10,
            $image->getUserId(),
            'User ID is incorrect.'
        );
    }

    /**
     * @test
     */
    public function testSetCategoryId()
    {
        $image = $this->buildImage();

        $image->setCategoryId(5);

        $this->assertEquals(
            5,
            $image->getCategoryId(),
            'Category ID is incorrect.'
        );
    }

    /**
     * @return Image
     */
    private function buildImage(): Image
    {
        $image = new Image();

        return $image->create('image-name', 'png', '/path/to/image', 1000);
    }
}
