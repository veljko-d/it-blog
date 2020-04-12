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
     * @param Image $image
     *
     * @return mixed|void
     * @throws DbException
     */
    public function store(Image $image)
    {
        $query = 'INSERT INTO images (name, ext, path, size, post_id, created_at)
			VALUES (:name, :ext, :path, :size, :postId, NOW())';

        $bindParams = [
            ':name'   => $image->getName(),
            ':ext'    => $image->getExt(),
            ':path'   => $image->getPath(),
            ':size'   => $image->getSize(),
            ':postId' => $image->getPostId(),
        ];

        try {
            $this->db->execute($query, $bindParams);
        } catch (PDOException $e) {
            throw new DbException($e->getMessage());
        }
    }

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
