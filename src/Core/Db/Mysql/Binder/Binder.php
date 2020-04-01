<?php

namespace App\Core\Db\Mysql\Binder;

use App\Core\Container\Container;
use App\Core\Db\Mysql\Binder\Binds\BindColumns;
use App\Core\Db\Mysql\Binder\Binds\BindParams;
use App\Core\Db\Mysql\Binder\Binds\BindValues;
use App\Exceptions\InvalidTypeException;
use PDOStatement;
use ReflectionException;

/**
 * Class Binder
 *
 * @package App\Core\Db\Mysql\Binder
 */
class Binder
{
    /**
     * @const
     */
    public const BIND_COLUMN = 'bindColumn';

    /**
     * @const
     */
    public const BIND_PARAM = 'bindParam';

    /**
     * @const
     */
    public const BIND_VALUE = 'bindValue';

    /**
     * @const
     */
    private const TYPES = [
        self::BIND_COLUMN => BindColumns::class,
        self::BIND_PARAM  => BindParams::class,
        self::BIND_VALUE  => BindValues::class,
    ];

    /**
     * @param PDOStatement $sth
     * @param array        $params
     * @param string       $bindType
     *
     * @return PDOStatement
     * @throws InvalidTypeException
     * @throws ReflectionException
     */
    public function bind(
        PDOStatement $sth,
        array $params,
        string $bindType
    ): PDOStatement {
        if (!isset(self::TYPES[$bindType])) {
            throw new InvalidTypeException("Invalid bind type: $bindType");
        }

        $bind = (Container::getInstance())->get(self::TYPES[$bindType]);

        return $bind->bind($sth, $params);
    }
}
