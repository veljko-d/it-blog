<?php

namespace Tests\Unit\Models;

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
}
