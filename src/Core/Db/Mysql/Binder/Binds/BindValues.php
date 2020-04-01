<?php

namespace App\Core\Db\Mysql\Binder\Binds;

use PDOStatement;

/**
 * Class BindValues
 *
 * @package App\Core\Db\Mysql\Binder\Binds
 */
class BindValues implements BindInterface
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
            $parameter = $param[0];
            $value = $param[1];
            $dataType = $param[2] ?? null;

            $sth->bindValue($parameter, $value, $dataType);
        }

        return $sth;
    }
}
