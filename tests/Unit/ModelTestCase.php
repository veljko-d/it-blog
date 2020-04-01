<?php

namespace Tests\Unit;

use App\Core\Db\Mysql\MysqlDriver;
use Tests\AbstractTestCase;

/**
 * Class ModelTestCase
 *
 * @package Tests\Unit
 */
abstract class ModelTestCase extends AbstractTestCase
{
    /**
     * @var
     */
    protected $db;

    /**
     * @var array
     */
    protected $tables = [];

    /**
     * @setUp
     */
    public function setUp(): void
    {
        $dbConfig = [
            'db_connection' => 'mysql',
            'db_host'       => '192.168.10.10',
            'db_name'       => 'it-blog',
            'user'          => 'homestead',
            'password'      => 'secret',
        ];

        /*
        .env is not loaded, so Config can't access it's parameters
        so, this is a temporary solution

        $config = (Container::getInstance()->get(Config::class));
        $dbConfig = $config->get('db');
        */

        $this->db = new MysqlDriver();
        $this->db->init($dbConfig);

        $this->db->beginTransaction();
        $this->cleanAllTables();
    }

    /**
     * @tearDown
     */
    public function tearDown(): void
    {
        $this->db->rollBack();
    }

    /**
     * Clean specified tables
     */
    protected function cleanAllTables()
    {
        foreach ($this->tables as $table) {
            $this->db->exec("DELETE FROM $table");
        }
    }
}
