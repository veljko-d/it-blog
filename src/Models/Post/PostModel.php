<?php

namespace App\Models\Post;

use App\Models\AbstractModel;
use App\Domain\Post;

/**
 * Class PostModel
 *
 * @package App\Models\Post
 */
class PostModel extends AbstractModel implements PostModelInterface
{
    /**
     * @const
     */
    const CLASSNAME = Post::class;
}
