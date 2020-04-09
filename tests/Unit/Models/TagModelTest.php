<?php

namespace Tests\Unit\Models;

use App\Models\Tag\TagModel;
use Tests\Unit\ModelTestCase;

/**
 * Class TagModelTest
 *
 * @package Tests\Unit\Models
 */
class TagModelTest extends ModelTestCase
{
    /**
     * @var array
     */
    protected $tables = [
        'tags',
        'post_tag',
        'posts',
        'users',
    ];

    /**
     * @var TagModel
     */
    protected $tagModel;

    /**
     * @setUp
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->tagModel = new TagModel($this->db);
    }
}
