<?php

namespace Tests\Unit\Models;

use App\Exceptions\DbException;
use App\Exceptions\NotFoundException;
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
     * @throws NotFoundException
     */
    public function testStoreTag()
    {
        $tag = $this->buildTag();

        $storedTag = $this->tagModel->store($tag);

        $this->assertSame(
            $tag->getName(),
            $storedTag->getName(),
            'Name is incorrect.'
        );
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

        $tagId = $this->insertTag($this->buildTag());
        $this->attachTagToPost($postId, $tagId);

        $tags = $this->tagModel->getByPost($postId);

        $this->assertCount(
            1,
            $tags,
            "Array size not as expected."
        );
    }

    /**
     * @throws DbException
     * @throws NotFoundException
     */
    public function testGetTagNotFound()
    {
        $this->expectException(NotFoundException::class);

        $this->tagModel->get('not-existing-tag');
    }

    /**
     * @throws DbException
     * @throws NotFoundException
     */
    public function testGetTag()
    {
        $tag = $this->buildTag();
        $this->insertTag($tag);

        $storedTag = $this->tagModel->get($tag->getSlug());

        $this->assertSame(
            'Tag Name',
            $storedTag->getName(),
            'Name is incorrect.'
        );
    }
}
