<?php

namespace App\Models\Tag;

use App\Models\AbstractModel;
use App\Domain\Tag;

/**
 * Class TagModel
 *
 * @package App\Models\Tag
 */
class TagModel extends AbstractModel implements TagModelInterface
{
    /**
     * @const
     */
    const CLASSNAME = Tag::class;
}
