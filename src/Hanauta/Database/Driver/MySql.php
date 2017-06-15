<?php
namespace Hanauta\Database\Driver;

use Hanauta\Database\Driver\PDODriverTrait;
use Hanauta\Database\Driver;

class MySql extends Driver
{
    protected $baseConfig = [
        'host' => 'localhost',
        'username' => 'root',
        'password' => '',
        'database' => 'hanauta',
        'port' => '3306',
        'encoding' => 'utf8',
    ];
}