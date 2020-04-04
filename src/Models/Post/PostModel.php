<?php

namespace App\Models\Post;

use App\Core\Db\Mysql\Binder\Binder;
use App\Exceptions\DbException;
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
