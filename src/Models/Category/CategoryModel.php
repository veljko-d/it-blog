<?php

namespace App\Models\Category;

use App\Core\Db\Mysql\Binder\Binder;
use App\Domain\Category;
use App\Exceptions\DbException;
use App\Models\AbstractModel;
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
}
