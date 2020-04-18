<?php

namespace App\Models\Category;

use App\Core\Db\Mysql\Binder\Binder;
use App\Domain\Category;
use App\Exceptions\DbException;
use App\Models\AbstractModel;
use App\Models\Post\PostModel;
use PDO;
use PDOException;

/**
 * Class CategoryModel
 *
 * @package App\Models\Category
 */
class CategoryModel extends AbstractModel implements CategoryModelInterface
{
    /**
     * @const
     */
    const CLASSNAME = Category::class;

    /**
     * @return mixed
     * @throws DbException
     */
    public function getParentCategories()
    {
        $query = 'SELECT id, name, category_id
            FROM categories
            WHERE category_id IS NULL';

        try {
            $parentCategories = $this->db->fetchAll(
                $query,
                [],
                PDO::FETCH_CLASS,
                self::CLASSNAME,
                Binder::BIND_PARAM
            );
        } catch (PDOException $e) {
            throw new DbException($e->getMessage());
        }

        foreach ($parentCategories as $parent) {
            $categories = $this->getSubcategoriesByParent($parent->getId());
            $parent->setCategories($categories);
        }

        return $parentCategories;
    }

    /**
     * @param int $id
     *
     * @return mixed
     * @throws DbException
     */
    public function getSubcategoriesByParent(int $id)
    {
        $query = 'SELECT id, name, category_id
                FROM categories
                WHERE category_id = :category_id';

        try {
            return $this->db->fetchAll(
                $query,
                [':category_id' => $id],
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
    public function getPostsByCategory(array $params): array
    {
        $start = $params['length'] * ($params['page'] - 1);

        $query = 'SELECT p.*, u.name AS user_name
            FROM posts p
            LEFT JOIN categories c ON p.category_id = c.id
            LEFT JOIN users u ON p.user_id = u.id
            WHERE c.slug = :slug
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
            LEFT JOIN categories c ON p.category_id = c.id
            WHERE c.slug = :slug';

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
}
