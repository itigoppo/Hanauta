<?php

namespace Hanauta\Database\Driver;

use PDO;
use PDOException;
use PDOStatement;

trait PDODriverTrait
{
    /**
     * @var PDO|null
     */
    protected $_connection;

    /**
     * @param string $dsn PDO-dns
     * @param array $config configuration
     * @return bool
     */
    protected function _connect($dsn, array $config)
    {
        try {
            $pdo = new PDO(
                $dsn, $config['username'], $config['password'], $config['options']
            );
            $this->connection($pdo);
        } catch (PDOException $e) {
            exit('データベース接続失敗。' . $e->getMessage());
        }

        return true;
    }

    /**
     * @param null|PDO $connection PDO connection instance.
     * @return null|PDO
     */
    public function connection($connection = null)
    {
        if ($connection !== null) {
            $this->_connection = $connection;
        }

        return $this->_connection;
    }

    /**
     * DB接続解除
     *
     * @return void
     */
    public function disconnect()
    {
        $this->_connection = null;
    }

    /**
     * @param string $query SQLQuery
     * @return PDOStatement
     */
    public function prepare($query)
    {
        $statement = $this->_connection->prepare($query);
        return new PDOStatement($statement, $this);
    }
}
