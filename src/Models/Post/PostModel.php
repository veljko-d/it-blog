<?php

namespace App\Models\Post;

use App\Core\Db\Mysql\Binder\Binder;
use App\Exceptions\DbException;
use App\Exceptions\NotFoundException;
use App\Models\AbstractModel;
use App\Domain\Post;
use PDO;
use PDOException;

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

    /**
     * @param Post $post
     *
     * @return Post|mixed
     * @throws DbException
     * @throws NotFoundException
     */
    public function store(Post $post)
    {
        $query = 'INSERT INTO posts (title, slug, content, source, user_id,
                category_id, created_at)
			VALUES (:title, :slug, :content, :source, :userId, :categoryId,
			    NOW())';

        $bindParams = [
            ':title'      => $post->getTitle(),
            ':slug'       => $slug = $post->getSlug(),
            ':content'    => $post->getContent(),
            ':source'     => $post->getSource(),
            ':categoryId' => $post->getCategoryId(),
            ':userId'     => $post->getUserId(),
        ];

        try {
            $this->db->execute($query, $bindParams);
        } catch (PDOException $e) {
            throw new DbException($e->getMessage());
        }

        return $this->get($slug);
    }

    /**
     * @param array $params
     *
     * @return array
     * @throws DbException
     */
    public function getAll(array $params): array
    {
        $start = $params['length'] * ($params['page'] - 1);
        $search = $params['search'];

        $query = 'SELECT p.*, u.name AS user_name
            FROM posts p
            LEFT JOIN users u ON p.user_id = u.id
            WHERE title LIKE :search OR content LIKE :search
            ORDER BY p.created_at DESC
            LIMIT :start, :length';

        $bindParams = [
            [':search', "%$search%", PDO::PARAM_STR],
            [':start', $start, PDO::PARAM_INT],
            [':length', $params['length'], PDO::PARAM_INT],
        ];

        try {
            return $this->db->fetchAll(
                $query,
                $bindParams,
                PDO::FETCH_CLASS,
                self::CLASSNAME,
                Binder::BIND_PARAM
            );
        } catch (PDOException $e) {
            throw new DbException($e->getMessage());
        }
    }

    /**
     * @param string $search
     *
     * @return int
     * @throws DbException
     */
    public function count(string $search): int
    {
        $query = 'SELECT COUNT(*)
            FROM posts
            WHERE title LIKE :search OR content LIKE :search';

        try {
            $numberOfPosts = $this->db->fetchAll(
                $query,
                [':search' => "%$search%"],
                PDO::FETCH_COLUMN
            );
        } catch (PDOException $e) {
            throw new DbException($e->getMessage());
        }

        return $numberOfPosts[0];
    }

    /**
     * @param string $slug
     *
     * @return Post
     * @throws DbException
     * @throws NotFoundException
     */
    public function get(string $slug): Post
    {
        $query = 'SELECT p.*, u.name AS user_name, c.slug AS category_slug,
                c.name AS category_name,
                (SELECT name FROM categories WHERE id = c.category_id)
                AS parent_category_name,
                (SELECT slug FROM categories WHERE id = c.category_id)
                AS parent_category_slug
            FROM posts p
            LEFT JOIN users u ON p.user_id = u.id
            LEFT JOIN categories c ON p.category_id = c.id
            WHERE p.slug = :slug';

        try {
            $post = $this->db->fetchAll(
                $query,
                [':slug' => $slug],
                PDO::FETCH_CLASS,
                self::CLASSNAME
            );
        } catch (PDOException $e) {
            throw new DbException($e->getMessage());
        }

        if (empty($post)) {
            throw new NotFoundException('Post not found.');
        }

        return $post[0];
    }

    /**
     * @param Post   $post
     * @param string $slug
     *
     * @return Post
     * @throws DbException
     * @throws NotFoundException
     */
    public function update(Post $post, string $slug)
    {
        $postId = $this->get($slug)->getId();

        $query = 'UPDATE posts
			SET title = :title, slug = :slug, content = :content,
			    source = :source, category_id = :category_id, updated_at = NOW()
			WHERE id = :id';

        $bindParams = [
            ':title'       => $post->getTitle(),
            ':slug'        => $slug = $post->getSlug(),
            ':content'     => $post->getContent(),
            ':source'      => $post->getSource(),
            ':category_id' => $post->getCategoryId(),
            ':id'          => $postId,
        ];

        try {
            $this->db->execute($query, $bindParams);
        } catch (PDOException $e) {
            throw new DbException($e->getMessage());
        }

        return $this->get($slug);
    }

    /**
     * @param string $slug
     *
     * @return mixed|void
     * @throws DbException
     */
    public function delete(string $slug)
    {
        $query = 'DELETE FROM posts WHERE slug = :slug';

        try {
            $this->db->execute($query, [':slug' => $slug]);
        } catch (PDOException $e) {
            throw new DbException($e->getMessage());
        }
    }
}
