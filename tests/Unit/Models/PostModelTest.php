<?php

namespace Tests\Unit\Models;

use App\Exceptions\DbException;
use App\Exceptions\NotFoundException;
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

    /**
     * @throws DbException
     * @throws NotFoundException
     */
    public function testStorePostThrowsDbException()
    {
        $this->expectException(DbException::class);

        $post = $this->buildPost();
        $this->postModel->store($post);
    }

    /**
     * @throws DbException
     * @throws NotFoundException
     */
    public function testStorePost()
    {
        $categoryId = $this->insertCategory();
        $userId = $this->insertUser($this->buildUser());

        $post = $this->buildPost($categoryId, $userId);
        $storedPost = $this->postModel->store($post);

        $this->assertSame(
            'Title Title',
            $storedPost->getTitle(),
            'Title is incorrect.'
        );

        $this->assertSame(
            $userId,
            $storedPost->getUserId(),
            'User ID is incorrect.'
        );
    }

    /**
     * @throws DbException
     */
    public function testGetAllEmpty()
    {
        $params = ['page' => 1, 'length' => 5, 'search' => ''];
        $posts = $this->postModel->getAll($params);

        $this->assertEmpty(
            $posts,
            "Array is not empty."
        );
    }

    /**
     * @throws DbException
     */
    public function testGetAll()
    {
        $categoryId = $this->insertCategory();
        $userId = $this->insertUser($this->buildUser());

        $post = $this->buildPost($categoryId, $userId);
        $this->insertPost($post);

        $params = ['page' => 1, 'length' => 5, 'search' => ''];
        $posts = $this->postModel->getAll($params);

        $this->assertCount(
            1,
            $posts,
            "Array size not as expected."
        );
    }

    /**
     * @throws DbException
     * @throws NotFoundException
     */
    public function testPostNotFound()
    {
        $this->expectException(NotFoundException::class);

        $this->postModel->get('title-title');
    }

    /**
     * @throws DbException
     * @throws NotFoundException
     */
    public function testGetPost()
    {
        $categoryId = $this->insertCategory();
        $userId = $this->insertUser($this->buildUser());

        $post = $this->buildPost($categoryId, $userId);
        $this->insertPost($post);

        $post = $this->postModel->get('title-title');

        $this->assertSame(
            'Title Title',
            $post->getTitle(),
            'Title is incorrect.'
        );
    }

    /**
     * @throws DbException
     * @throws NotFoundException
     */
    public function testUpdatePostNotFound()
    {
        $this->expectException(NotFoundException::class);

        $post = $this->buildPost(1, 1);

        $this->postModel->update($post, $post->getSlug());
    }

    /**
     * @throws DbException
     * @throws NotFoundException
     */
    public function testUpdatePost()
    {
        $categoryId = $this->insertCategory();
        $userId = $this->insertUser($this->buildUser());

        $post = $this->buildPost($categoryId, $userId);
        $storedPost = $this->postModel->store($post);

        $this->assertSame(
            'title-title',
            $slug = $storedPost->getSlug(),
            'Slug is incorrect.'
        );

        $post = $this->updatePost($storedPost);
        $updatedPost = $this->postModel->update($post, $slug);

        $this->assertSame(
            'New Title',
            $updatedPost->getTitle(),
            'Title is incorrect.'
        );
    }
}
