<?php

namespace Hanauta\Database\Driver;

use PDO;
use PDOException;

trait PDODriverTrait
{
    /**
     * @var PDO
     */
    protected $connection;

    protected function connect($dsn, array $config)
    {
        try {
            $pdo = new PDO(
                $dsn,$config['username'],$config['password'],$config['options']
            );
            $this->connection($pdo);
        } catch (PDOException $e) {
            exit('データベース接続失敗。'.$e->getMessage());
        }
    }

    /**
     * @param null|PDO $connection PDO connection instance.
     * @return null|PDO
     */
    public function connection($connection = null)
    {
        if ($connection !== null) {
            $this->connection = $connection;
        }

        return $this->connection;
    }
}
