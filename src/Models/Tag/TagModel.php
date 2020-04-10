<?php

namespace App\Models\Tag;

use App\Exceptions\DbException;
use App\Models\AbstractModel;
use App\Domain\Tag;
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
}
