<?php

namespace Tests\Unit\Models;

use App\Domain\Post;
use App\Exceptions\DbException;
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
        $categoryId = $this->addCategory();
        $userId = $this->addUser();

        $post = $this->buildPost($categoryId, $userId);
        $this->addPost($post);

        $params = ['page' => 1, 'length' => 5, 'search' => ''];
        $posts = $this->postModel->getAll($params);

        $this->assertCount(
            1,
            $posts,
            "Array size not as expected."
        );
    }

    /**
     * @param int $categoryId
     * @param int $userId
     *
     * @return Post
     */
    private function buildPost(int $categoryId = 1, int $userId = 1): Post
    {
        $post = new Post;

        return $post->create(
            'Title Title',
            'title-title',
            'Content Content Content',
            'www.source.com',
            $categoryId,
            $userId
        );
    }

    /**
     * @return int
     */
    private function addUser(): int
    {
        $params = [
            ':name'     => 'John',
            ':slug'     => 'john',
            ':email'    => 'john@example.com',
            ':password' => 'a1b1c1d1e1f1',
        ];

        $query = 'INSERT INTO users (name, slug, email, password, created_at)
			VALUES (:name, :slug, :email, :password, NOW())';

        $this->db->execute($query, $params);

        return $this->db->lastInsertId();
    }

    /**
     * @return int
     */
    private function addCategory(): int
    {
        $params = [':name' => 'Web', ':slug' => 'web'];

        $query = 'INSERT INTO categories (name, slug, created_at)
			VALUES (:name, :slug, NOW())';

        $this->db->execute($query, $params);

        return $this->db->lastInsertId();
    }

    /**
     * @param Post $post
     */
    private function addPost(Post $post)
    {
        $query = 'INSERT INTO posts (title, slug, content, source, user_id,
                category_id, created_at)
			VALUES (:title, :slug, :content, :source, :userId, :categoryId,
			    NOW())';

        $bindParams = [
            ':title'      => $post->getTitle(),
            ':slug'       => $post->getSlug(),
            ':content'    => $post->getContent(),
            ':source'     => $post->getSource(),
            ':categoryId' => $post->getCategoryId(),
            ':userId'     => $post->getUserId(),
        ];

        $this->db->execute($query, $bindParams);
    }
}
