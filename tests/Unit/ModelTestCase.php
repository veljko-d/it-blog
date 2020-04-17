<?php

namespace Tests\Unit;

use App\Core\Db\Mysql\MysqlDriver;
use App\Domain\Image;
use App\Domain\Post;
use App\Domain\Tag;
use App\Domain\User;
use Tests\AbstractTestCase;

/**
 * Class ModelTestCase
 *
 * @package Tests\Unit
 */
abstract class ModelTestCase extends AbstractTestCase
{
    /**
     * @var
     */
    protected $db;

    /**
     * @var array
     */
    protected $tables = [];

    /**
     * @setUp
     */
    public function setUp(): void
    {
        $dbConfig = [
            'db_connection' => 'mysql',
            'db_host'       => '192.168.10.10',
            'db_name'       => 'it-blog',
            'user'          => 'homestead',
            'password'      => 'secret',
        ];

        /*
        .env is not loaded, so Config can't access it's parameters
        so, this is a temporary solution

        $config = (Container::getInstance()->get(Config::class));
        $dbConfig = $config->get('db');
        */

        $this->db = new MysqlDriver();
        $this->db->init($dbConfig);

        $this->db->beginTransaction();
        $this->cleanAllTables();
    }

    /**
     * @tearDown
     */
    public function tearDown(): void
    {
        $this->db->rollBack();
    }

    /**
     * Clean specified tables
     */
    protected function cleanAllTables()
    {
        foreach ($this->tables as $table) {
            $this->db->exec("DELETE FROM $table");
        }
    }

    /**
     * @return User
     */
    protected function buildUser(): User
    {
        $user = new User();

        return $user->create(
            'Dallas',
            'dallas',
            'dallas@example.com',
            'dallas123'
        );
    }

    /**
     * @param User $user
     *
     * @return int
     */
    protected function insertUser(User $user): int
    {
        $params = [
            ':name'     => $user->getName(),
            ':slug'     => $user->getSlug(),
            ':email'    => $user->getEmail(),
            ':password' => $user->getPassword(),
        ];

        $query = 'INSERT INTO users (name, slug, email, password, created_at)
			VALUES (:name, :slug, :email, :password, NOW())';

        $this->db->execute($query, $params);

        return $this->db->lastInsertId();
    }

    /**
     * @return int
     */
    protected function insertCategory(): int
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
     * @return Post
     */
    protected function buildPost(int $categoryId = 1, int $userId = 1): Post
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
     * @param Post $post
     *
     * @return int
     */
    protected function insertPost(Post $post): int
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

        return $this->db->lastInsertId();
    }

    /**
     * @return Tag
     */
    protected function buildTag(): Tag
    {
        $tag = new Tag();

        return $tag->create('Tag Name', 'tag-name');
    }

    /**
     * @param Tag $tag
     *
     * @return int
     */
    protected function insertTag(Tag $tag): int
    {
        $params = [':name' => $tag->getName(), ':slug' => $tag->getSlug()];

        $query = 'INSERT INTO tags (name, slug, created_at)
			VALUES (:name, :slug, NOW())';

        $this->db->execute($query, $params);

        return $this->db->lastInsertId();
    }

    /**
     * @param int $postId
     * @param int $tagId
     */
    protected function attachTagToPost(int $postId, int $tagId)
    {
        $params = [':post_id' => $postId, ':tag_id' => $tagId];

        $query = 'INSERT INTO post_tag(post_id, tag_id)
			VALUES(:post_id, :tag_id)
			ON DUPLICATE KEY UPDATE
            post_id = :post_id';

        $this->db->execute($query, $params);
    }

    /**
     * @return Image
     */
    protected function buildImage(): Image
    {
        $image = new Image();

        return $image->create(
            'image-name',
            'png',
            'path/to/image',
            1000
        );
    }

    /**
     * @param Image $image
     *
     * @return int
     */
    protected function insertImage(Image $image): int
    {
        $params = [
            ':name'   => $image->getName(),
            ':ext'    => $image->getExt(),
            ':size'   => $image->getSize(),
            ':path'   => $image->getPath(),
            ':postId' => $image->getPostId(),
        ];

        $query = 'INSERT INTO images (name, ext, path, size, post_id, created_at)
			VALUES (:name, :ext, :path, :size, :postId, NOW())';

        $this->db->execute($query, $params);

        return $this->db->lastInsertId();
    }

    /**
     * @return int
     */
    protected function insertParentCategory(): int
    {
        $parent = [':name' => 'Cat 1', ':slug' => 'cat-1'];

        $query = 'INSERT INTO categories (name, slug)
			VALUES (:name, :slug)';

        $this->db->execute($query, $parent);

        return $this->db->lastInsertId();
    }

    /**
     * @param int $parentId
     */
    protected function insertChildrenCategories(int $parentId)
    {
        $children = [
            [':name' => 'Cat 3', ':slug' => 'cat-3', ':category_id' => $parentId],
            [':name' => 'Cat 4', ':slug' => 'cat-4', ':category_id' => $parentId],
            [':name' => 'Cat 5', ':slug' => 'cat-5', ':category_id' => $parentId],
        ];

        foreach ($children as $child) {
            $query = 'INSERT INTO categories (name, slug, category_id)
			    VALUES (:name, :slug, :category_id)';

            $this->db->execute($query, $child);
        }
    }
}
