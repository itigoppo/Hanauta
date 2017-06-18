<?php

namespace Hanauta\Database;


use InvalidArgumentException;
use PDO;
use PDOStatement;

abstract class Driver
{
    /**
     * @var array
     */
    protected $_config;

    /**
     * @var array
     */
    protected $_baseConfig = [];

    public function __construct($config = [])
    {
        if (empty($config['username'])) {
            throw new InvalidArgumentException('接続情報が不足しています');
        }
        $config += $this->_baseConfig;
        $this->_config = $config;
    }

    /**
     * @return bool
     */
    abstract public function connect();

    /**
     * @param null|PDO $connection PDO connection instance.
     * @return null|PDO
     */
    abstract public function connection($connection = null);

    /**
     * @return void
     */
    abstract public function disconnect();

    /**
     * @param $query
     * @return PDOStatement
     */
    abstract public function prepare($query);
}
