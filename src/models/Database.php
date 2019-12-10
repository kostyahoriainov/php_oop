<?php

namespace Models;


use PDO;
use PDOException;

class Database
{
    private static $connection = null;

    private function __construct() {}

    private function __clone() {}

    public static function getConnection(string $database = 'mysql'): PDO
    {
        try {
            if (!self::$connection) {
                $database_config = DB_CONFIG[$database];

                $dns = $database . ':dbname=' . $database_config['database'] . ';host=' . $database_config['host'];

                self::$connection = new PDO(
                    $dns,
                    $database_config['user'],
                    $database_config['password']
                );
            }
        } catch (PDOException $e) {
            echo 'Connection error: ' . $e->getMessage();
        }

        return self::$connection;
    }

}