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
        $categoryId = $this->addCategory();
        $userId = $this->addUser();
        $postId = $this->addPost($categoryId, $userId);
        $tagId = $this->addTag();
        $this->attachTagToPost($postId, $tagId);

        $tags = $this->tagModel->getByPost($postId);

        $this->assertCount(
            1,
            $tags,
            "Array size not as expected."
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
     * @param int $categoryId
     * @param int $userId
     *
     * @return int
     */
    private function addPost(int $categoryId, int $userId): int
    {
        $query = 'INSERT INTO posts (title, slug, content, source, user_id,
                category_id, created_at)
			VALUES (:title, :slug, :content, :source, :userId, :categoryId,
			    NOW())';

        $bindParams = [
            ':title'      => 'Title Title',
            ':slug'       => 'title-title',
            ':content'    => 'Content Content',
            ':source'     => 'www.source.com',
            ':categoryId' => $categoryId,
            ':userId'     => $userId,
        ];

        $this->db->execute($query, $bindParams);

        return $this->db->lastInsertId();
    }

    /**
     * @return int
     */
    private function addTag(): int
    {
        $params = [':name' => 'image-name', ':slug' => 'png',];

        $query = 'INSERT INTO tags (name, slug, created_at)
			VALUES (:name, :slug, NOW())';

        $this->db->execute($query, $params);

        return $this->db->lastInsertId();
    }

    /**
     * @param int $postId
     * @param int $tagId
     */
    public function attachTagToPost(int $postId, int $tagId)
    {
        $params = [':post_id' => $postId, ':tag_id' => $tagId];

        $query = 'INSERT INTO post_tag(post_id, tag_id)
			VALUES(:post_id, :tag_id)
			ON DUPLICATE KEY UPDATE
            post_id = :post_id';

        $this->db->execute($query, $params);
    }
}
