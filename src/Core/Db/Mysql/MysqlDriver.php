<?php

namespace App\Core\Db\Mysql;

use App\Core\Container\Container;
use App\Core\Db\DbInterface;
use App\Core\Db\Mysql\Binder\Binder;
use App\Exceptions\InvalidTypeException;
use PDO;
use PDOStatement;
use ReflectionException;

/**
 * Class MysqlDriver
 *
 * @package App\Core\Mysql\Db
 */
class MysqlDriver implements DbInterface
{
    /**
     * @var PDO
     */
    private $db;

    /**
     * @var Binder
     */
    private $binder;

    /**
     * @param array $dbConfig
     *
     * @throws ReflectionException
     */
    public function init(array $dbConfig): void
    {
        $this->db = new PDO(
            $dbConfig['db_connection'] . ':host=' . $dbConfig['db_host']
                . ';dbname=' . $dbConfig['db_name'],
            $dbConfig['user'],
            $dbConfig['password'],
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
        );
        $this->binder = (Container::getInstance()->get(Binder::class));
    }

    /**
     * @param string $query
     *
     * @return mixed
     */
    public function fetch(string $query)
    {
        $sth = $this->db->query($query);

        return $sth->fetch();
    }

    /**
     * @param string      $query
     * @param array       $params
     * @param             $fetchStyle
     * @param null        $fetchArgument
     * @param string|null $bindType
     *
     * @return array
     * @throws InvalidTypeException
     * @throws ReflectionException
     */
    public function fetchAll(
        string $query,
        array $params,
        $fetchStyle,
        $fetchArgument = null,
        string $bindType = null
    ): array {
        $sth = $this->execute($query, $params, $bindType);

        return $sth->fetchAll($fetchStyle, $fetchArgument);
    }

    /**
     * @param string      $query
     * @param array       $params
     * @param string|null $bindType
     *
     * @return PDOStatement
     * @throws InvalidTypeException
     * @throws ReflectionException
     */
    public function execute(
        string $query,
        array $params,
        string $bindType = null
    ): PDOStatement {
        $sth = $this->db->prepare($query);

        if ($bindType) {
            $sth = $this->binder->bind($sth, $params, $bindType);
            $params = null;
        }

        $sth->execute($params);

        return $sth;
    }

    /**
     * @param string $query
     *
     * @return false|int
     */
    public function exec(string $query)
    {
        return $this->db->exec($query);
    }

    /**
     * @return int
     */
    public function lastInsertId(): int
    {
        return $this->db->lastInsertId();
    }

    /**
     * @return bool
     */
    public function beginTransaction()
    {
        return $this->db->beginTransaction();
    }

    /**
     * @return bool
     */
    public function rollBack()
    {
        return $this->db->rollBack();
    }

    /**
     * @return bool
     */
    public function commit()
    {
        return $this->db->commit();
    }
}
