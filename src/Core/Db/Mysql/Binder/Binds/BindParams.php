<?php

namespace App\Core\Db\Mysql\Binder\Binds;

use PDOStatement;

/**
 * Class BindParams
 *
 * @package App\Core\Db\Mysql\Binder\Binds
 */
class BindParams implements BindInterface
{
    /**
     * @param PDOStatement $sth
     * @param array        $params
     *
     * @return PDOStatement
     */
    public function bind(PDOStatement $sth, array $params): PDOStatement
    {
        foreach ($params as &$param) {
            $parameter = $param[0];
            $variable = &$param[1];
            $dataType = $param[2] ?? null;
            $length = $param[3] ?? null;
            $driverOptions = $param[4] ?? null;

            $sth->bindParam($parameter, $variable, $dataType, $length, $driverOptions);
        }

        return $sth;
    }
}
