<?php

namespace Tests\Unit\Actions;

use App\Core\Loggers\MonologDriver;
use App\Core\Storage;
use App\Domain\Image;
use App\Models\Image\ImageModel;
use PHPUnit\Framework\MockObject\MockObject;
use Tests\AbstractTestCase;

/**
 * Class ImageActionTestCase
 *
 * @package Tests\Unit\Actions
 */
class ImageActionTestCase extends AbstractTestCase
{
    /**
     * @var MonologDriver|MockObject
     */
    protected $logger;

    /**
     * @var ImageModel|MockObject
     */
    protected $imageModel;

    /**
     * @var Image|MockObject
     */
    protected $image;

    /**
     * @var Storage|MockObject
     */
    protected $storage;

    /**
     * @setUp
     */
    public function setUp(): void
    {
        $this->logger = $this->createMock(MonologDriver::class);
        $this->imageModel = $this->createMock(ImageModel::class);
        $this->image = $this->createMock(Image::class);
        $this->storage = $this->createMock(Storage::class);
    }
}
