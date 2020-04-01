<?php

namespace App\Core\Db\Mysql\Binder\Binds;

use PDOStatement;

/**
 * Class BindColumns
 *
 * @package App\Core\Db\Mysql\Binder\Binds
 */
class BindColumns implements BindInterface
{
    /**
     * @param PDOStatement $sth
     * @param array        $params
     *
     * @return PDOStatement
     */
    public function bind(PDOStatement $sth, array $params): PDOStatement
    {
        foreach ($params as $param) {
            $column = $param[0];
            $param = &$param[1];
            $type = $param[2] ?? null;
            $maxLen = $param[3] ?? null;
            $driverData = $param[4] ?? null;

            $sth->bindColumn($column, $param, $type, $maxLen, $driverData);
        }

        return $sth;
    }
}
