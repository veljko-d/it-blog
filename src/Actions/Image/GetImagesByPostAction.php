<?php

namespace App\Actions\Image;

/**
 * Class GetImagesByPostAction
 *
 * @package App\Actions\Image
 */
class GetImagesByPostAction extends AbstractImageAction
{
    /**
     * @param int $postId
     *
     * @return array
     */
    public function execute(int $postId): array
    {
        return $this->imageModel->getByPost($postId);
    }
}
