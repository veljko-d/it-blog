<?php

namespace App\Core\Db;

/**
 * Interface DbInterface
 *
 * @package App\Core\Db
 */
interface DbInterface
{
    /**
     * @param array $dbConfig
     *
     * @return mixed
     */
    public function init(array $dbConfig);
}
