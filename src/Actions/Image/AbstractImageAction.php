<?php

namespace App\Actions\Image;

use App\Core\Loggers\LoggerInterface;
use App\Core\Storage;
use App\Domain\Image;
use App\Models\Image\ImageModelInterface;

/**
 * Class AbstractImageAction
 *
 * @package App\Actions\Image
 */
abstract class AbstractImageAction
{
    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @var ImageModelInterface
     */
    protected $imageModel;

    /**
     * @var Image
     */
    protected $image;

    /**
     * @var Storage
     */
    protected $storage;

    /**
     * AbstractImageAction constructor.
     *
     * @param LoggerInterface     $logger
     * @param ImageModelInterface $imageModel
     * @param Image               $image
     * @param Storage             $storage
     */
    public function __construct(
        LoggerInterface $logger,
        ImageModelInterface $imageModel,
        Image $image,
        Storage $storage
    ) {
        $this->logger = $logger;
        $this->imageModel = $imageModel;
        $this->image = $image;
        $this->storage = $storage;
    }
}
