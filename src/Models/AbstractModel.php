<?php

namespace App\Models;

use App\Core\Db\DbInterface;

/**
 * Class AbstractModel
 *
 * @package App\Models
 */
abstract class AbstractModel
{
    /**
     * @var DbInterface
     */
    protected $db;

    /**
     * AbstractModel constructor.
     *
     * @param DbInterface $db
     */
    public function __construct(DbInterface $db)
    {
        $this->db = $db;
    }
}
