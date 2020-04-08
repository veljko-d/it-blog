<?php

namespace App\Models\Image;

use App\Domain\Image;
use App\Models\AbstractModel;

/**
 * Class ImageModel
 *
 * @package App\Models\Image
 */
class ImageModel extends AbstractModel implements ImageModelInterface
{
    /**
     * @const
     */
    const CLASSNAME = Image::class;
}
