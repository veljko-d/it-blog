<?php

namespace App\Models\Post;

use App\Models\ModelInterface;

/**
 * Interface PostModelInterface
 *
 * @package App\Models\Post
 */
interface PostModelInterface extends ModelInterface
{
    /**
     * @param array $params
     *
     * @return array
     */
    public function getAll(array $params): array;
}
