<?php

namespace App\Actions\Image;

use App\Exceptions\DbException;

/**
 * Class StoreImageAction
 *
 * @package App\Actions\Image
 */
class StoreImageAction extends AbstractImageAction
{
    /**
     * @const
     */
    private const POST_IMAGES_PATH = '/images';

    /**
     * @param array $images
     * @param int   $postId
     *
     * @throws DbException
     */
    public function execute(array $images, int $postId)
    {
        foreach ($images as $image) {
            $this->store($image, $postId);
        }
    }

    /**
     * @param array $image
     * @param       $postId
     *
     * @throws DbException
     */
    private function store(array $image, $postId)
    {
        $name = time() . '_' . mt_rand(1000, 9999);
        $ext = strtolower(pathinfo($image['name'], PATHINFO_EXTENSION));
        $link = getenv('BASE_DIR') . '/public/storage';
        $path = readlink($link) . self::POST_IMAGES_PATH;
        $fullPath = readlink($link) . self::POST_IMAGES_PATH . "/$name.$ext";

        try {
            $imageInstance = $this->image->create($name, $ext, $path, $image['size']);
            $imageInstance->setPostId($postId);

            $this->storage->storeFile($image['tmp_name'], $fullPath);
            $this->imageModel->store($imageInstance);
        } catch (DbException $e) {
            throw $e;
        }
    }
}
