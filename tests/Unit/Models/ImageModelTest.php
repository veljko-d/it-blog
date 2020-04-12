<?php

namespace Tests\Unit\Models;

use App\Exceptions\DbException;
use App\Models\Image\ImageModel;
use Tests\Unit\ModelTestCase;

/**
 * Class ImageModelTest
 *
 * @package Tests\Unit\Models
 */
class ImageModelTest extends ModelTestCase
{
    /**
     * @var array
     */
    protected $tables = [
        'images',
        'users',
        'posts',
    ];

    /**
     * @var ImageModel
     */
    protected $imageModel;

    /**
     * @setUp
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->imageModel = new ImageModel($this->db);
    }

    /**
     * @throws DbException
     */
    public function testStoreImageThrowsDbException()
    {
        $this->expectException(DbException::class);

        $image = $this->buildImage();
        $image->setPostId(3);
        $this->imageModel->store($image);
    }

    /**
     * @throws DbException
     */
    public function testStoreImage()
    {
        $categoryId = $this->insertCategory();
        $userId = $this->insertUser($this->buildUser());

        $post = $this->buildPost($categoryId, $userId);
        $postId = $this->insertPost($post);

        $image = $this->buildImage();
        $image->setPostId($postId);
        $this->imageModel->store($image);

        $images = $this->imageModel->getByPost($postId);

        $this->assertCount(
            1,
            $images,
            "Array size not as expected."
        );
    }

    /**
     * @throws DbException
     */
    public function testGetImagesByPostArrayEmpty()
    {
        $images = $this->imageModel->getByPost(3);

        $this->assertEmpty(
            $images,
            "Array is not empty."
        );
    }

    /**
     * @throws DbException
     */
    public function testGetImagesByPost()
    {
        $categoryId = $this->insertCategory();
        $userId = $this->insertUser($this->buildUser());

        $post = $this->buildPost($categoryId, $userId);
        $postId = $this->insertPost($post);

        $image = $this->buildImage();
        $image->setPostId($postId);
        $this->insertImage($image);

        $images = $this->imageModel->getByPost($postId);

        $this->assertCount(
            1,
            $images,
            "Array size not as expected."
        );
    }
}
