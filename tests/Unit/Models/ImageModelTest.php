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
        $this->addImage();

        $images = $this->imageModel->getByPost(2);

        $this->assertCount(
            1,
            $images,
            "Array size not as expected."
        );
    }

    /**
     * Insert new image into the database
     */
    private function addImage()
    {
        $params = [
            ':name'   => 'image-name',
            ':ext'    => 'png',
            ':size'   => 1000,
            ':path'   => '/path/to/image',
            ':postId' => 2,
        ];

        $query = 'INSERT INTO images (name, ext, path, size, post_id, created_at)
			VALUES (:name, :ext, :path, :size, :postId, NOW())';

        $this->db->execute($query, $params);
    }
}
