<?php

namespace App\Core\Db\Mysql\Binder\Binds;

use PDOStatement;

/**
 * Interface BindInterface
 *
 * @package App\Core\Db\Mysql\Binder\Binds
 */
interface BindInterface
{
    /**
     * @param PDOStatement $sth
     * @param array        $params
     *
     * @return PDOStatement
     */
    public function bind(PDOStatement $sth, array $params): PDOStatement;
}
