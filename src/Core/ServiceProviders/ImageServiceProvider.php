<?php

namespace App\Core\ServiceProviders;

use App\Models\Image\ImageModel;
use App\Models\Image\ImageModelInterface;

/**
 * Class ImageServiceProvider
 *
 * @package App\Core\ServiceProviders
 */
class ImageServiceProvider extends AbstractServiceProvider
{
    /**
     * @return mixed|void
     */
    public function register()
    {
        $this->container->set(ImageModelInterface::class, ImageModel::class);
    }
}
