<?php

namespace Tests\Unit\Models;

use App\Models\Post\PostModel;
use Tests\Unit\ModelTestCase;

/**
 * Class PostModelTest
 *
 * @package Tests\Unit\Models
 */
class PostModelTest extends ModelTestCase
{
    /**
     * @var array
     */
    protected $tables = [
        'posts',
        'users',
        'categories',
    ];

    /**
     * @var PostModel
     */
    protected $postModel;

    /**
     * @setUp
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->postModel = new PostModel($this->db);
    }
}
