<?php

namespace App\Models\Tag;

use App\Core\Db\Mysql\Binder\Binder;
use App\Exceptions\DbException;
use App\Exceptions\NotFoundException;
use App\Models\AbstractModel;
use App\Domain\Tag;
use App\Models\Post\PostModel;
use PDO;
use PDOException;

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

    /**
     * @param Tag $tag
     *
     * @return Tag
     * @throws DbException
     * @throws NotFoundException
     */
    public function store(Tag $tag)
    {
        $query = 'INSERT INTO tags (name, slug, created_at)
			VALUES (:name, :slug, NOW())';

        $bindParams = [
            ':name' => $tag->getName(),
            ':slug' => $slug = $tag->getSlug(),
        ];

        try {
            $this->db->execute($query, $bindParams);
        } catch (PDOException $e) {
            throw new DbException($e->getMessage());
        }

        return $this->get($slug);
    }

    /**
     * @param int $postId
     * @param int $tagId
     *
     * @throws DbException
     */
    public function attachTagToPost(int $postId, int $tagId)
    {
        $query = 'INSERT INTO post_tag(post_id, tag_id)
			VALUES(:post_id, :tag_id)
			ON DUPLICATE KEY UPDATE
            post_id = :post_id';

        $bindParams = [':post_id' => $postId, ':tag_id' => $tagId];

        try {
            $this->db->execute($query, $bindParams);
        } catch (PDOException $e) {
            throw new DbException($e->getMessage());
        }
    }

    /**
     * @param int $postId
     * @param int $tagId
     *
     * @throws DbException
     */
    public function detachTagAndPost(int $postId, int $tagId)
    {
        $query = 'DELETE FROM post_tag
            WHERE post_id = :post_id AND tag_id = :tag_id';

        $bindParams = [':post_id' => $postId, ':tag_id' => $tagId];

        try {
            $this->db->execute($query, $bindParams);
        } catch (PDOException $e) {
            throw new DbException($e->getMessage());
        }
    }

    /**
     * @param int $postId
     *
     * @return mixed
     * @throws DbException
     */
    public function getByPost(int $postId): array
    {
        $query = 'SELECT t.id, t.name, t.slug
            FROM tags t
            LEFT JOIN post_tag pt ON t.id = pt.tag_id
            WHERE pt.post_id = :post_id';

        try {
            return $this->db->fetchAll(
                $query,
                [':post_id' => $postId],
                PDO::FETCH_CLASS,
                self::CLASSNAME
            );
        } catch (PDOException $e) {
            throw new DbException($e->getMessage());
        }
    }

    /**
     * @param array $params
     *
     * @return array
     * @throws DbException
     */
    public function getPostsByTag(array $params): array
    {
        $start = $params['length'] * ($params['page'] - 1);

        $query = 'SELECT p.*, u.name AS user_name
            FROM posts p
            LEFT JOIN post_tag pt ON p.id = pt.post_id
            LEFT JOIN tags t ON t.id = pt.tag_id
            LEFT JOIN users u ON p.user_id = u.id
            WHERE t.slug = :slug
            ORDER BY p.created_at DESC
            LIMIT :start, :length';

        $bindParams = [
            [':slug', $params['slug'], PDO::PARAM_STR],
            [':start', $start, PDO::PARAM_INT],
            [':length', $params['length'], PDO::PARAM_INT],
        ];

        try {
            return $this->db->fetchAll(
                $query,
                $bindParams,
                PDO::FETCH_CLASS,
                PostModel::CLASSNAME,
                Binder::BIND_PARAM
            );
        } catch (PDOException $e) {
            throw new DbException($e->getMessage());
        }
    }

    /**
     * @param string $slug
     *
     * @return int
     * @throws DbException
     */
    public function count(string $slug): int
    {
        $query = 'SELECT COUNT(*)
            FROM posts p
            LEFT JOIN post_tag pt ON p.id = pt.post_id
            LEFT JOIN tags t ON t.id = pt.tag_id
            WHERE t.slug = :slug';

        try {
            $numberOfPosts = $this->db->fetchAll(
                $query,
                [':slug' => $slug],
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
     * @return Tag
     * @throws DbException
     * @throws NotFoundException
     */
    public function get(string $slug): Tag
    {
        $query = 'SELECT * FROM tags WHERE slug = :slug';

        try {
            $tag = $this->db->fetchAll(
                $query,
                [':slug' => $slug],
                PDO::FETCH_CLASS,
                self::CLASSNAME
            );
        } catch (PDOException $e) {
            throw new DbException($e->getMessage());
        }

        if (empty($tag)) {
            throw new NotFoundException('Tag not found.');
        }

        return $tag[0];
    }
}
