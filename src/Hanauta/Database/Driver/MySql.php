<?php

namespace Hanauta\Database\Driver;

use Hanauta\Database\Driver;
use PDO;
use PDOStatement;

class MySql extends Driver
{
    use PDODriverTrait;

    protected $_baseConfig = [
        'host' => 'localhost',
        'username' => 'root',
        'password' => '',
        'database' => 'hanauta',
        'port' => '3306',
        'encoding' => 'utf8',
        'timezone' => 'Asia/Tokyo',
        'options' => [],
        'persistent' => true,
    ];

    /**
     * @return bool
     */
    public function connect()
    {
        if ($this->_connection) {
            return false;
        }
        $config = $this->_config;

        $init = [];

        if (!empty($config['encoding'])) {
            $init[] = sprintf('SET NAMES %s', $config['encoding']);
        }

        if (!empty($config['timezone'])) {
            $init[] = sprintf("SET time_zone = '%s'", $config['timezone']);
        }

        $config['options'] += [
            PDO::ATTR_PERSISTENT => $config['persistent'],
            PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        ];

        $dsn = 'mysql:host=%s;port=%s;dbname=%s;charset=%s';
        $this->_connect(sprintf($dsn, $config['host'], $config['port'], $config['database'], $config['encoding']), $config);

        if (!empty($init)) {
            $connection = $this->connection();
            foreach ((array)$init as $command) {
                $connection->exec($command);
            }
        }

        return true;
    }

    /**
     * @param string $query SQLQuery
     * @return PDOStatement
     */
    public function prepare($query)
    {
        $this->connect();
        $result = $this->_connection->prepare($query);

        return $result;
    }
}
