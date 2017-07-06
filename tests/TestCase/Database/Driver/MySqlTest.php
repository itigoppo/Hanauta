<?php

namespace Hanauta\Test\Database\Driver;

use Hanauta\Database\Driver\MySql;

class MySqlTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        parent::setUp();
    }

    public function testConnect()
    {
        $driver = new MySql([
            'host' => getenv('DATABASE_HOST_NAME'),
            'username' => getenv('DATABASE_USERNAME'),
            'password' => getenv('DATABASE_PASSWORD'),
            'database' => getenv('DATABASE_NAME'),
        ]);

        $sth = $driver->prepare('show tables');
        $sth->execute();

        var_dump($sth->fetchAll());
    }
}
