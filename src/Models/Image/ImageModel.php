<?php

namespace App\Models\Image;

use App\Domain\Image;
use App\Exceptions\DbException;
use App\Models\AbstractModel;
use PDO;
use PDOException;

/**
 * Class ImageModel
 *
 * @package App\Models\Image
 */
class ImageModel extends AbstractModel implements ImageModelInterface
{
    /**
     * @const
     */
    const CLASSNAME = Image::class;

    /**
     * @param int $postId
     *
     * @return array
     * @throws DbException
     */
    public function getByPost(int $postId): array
    {
        $query = 'SELECT *
            FROM images 
            WHERE post_id = :post_id';

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
