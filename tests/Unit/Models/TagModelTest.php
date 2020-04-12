<?php

namespace Tests\Unit\Models;

use App\Exceptions\DbException;
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

    /**
     * @throws DbException
     */
    public function testGetTagsByPostArrayEmpty()
    {
        $tags = $this->tagModel->getByPost(3);

        $this->assertEmpty(
            $tags,
            "Array is not empty."
        );
    }

    /**
     * @throws DbException
     */
    public function testGetTagsByPost()
    {
        $categoryId = $this->insertCategory();
        $userId = $this->insertUser($this->buildUser());

        $post = $this->buildPost($categoryId, $userId);
        $postId = $this->insertPost($post);

        $tagId = $this->insertTag();
        $this->attachTagToPost($postId, $tagId);

        $tags = $this->tagModel->getByPost($postId);

        $this->assertCount(
            1,
            $tags,
            "Array size not as expected."
        );
    }
}
