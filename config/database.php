<?php
declare(strict_types=1);

class Database
{
    private static ?PDO $instance = null;

    private function __construct() {}
    private function __clone() {}

    public static function getConnection(): PDO
    {
        if (self::$instance === null) {

            $host   = getenv('MYSQLHOST') ?: getenv('DB_HOST') ?: 'localhost';
            $port   = getenv('MYSQLPORT') ?: getenv('DB_PORT') ?: '3306';
            $dbname = getenv('MYSQLDATABASE') ?: getenv('DB_NAME') ?: 'meter_testing_db';
            $user   = getenv('MYSQLUSER') ?: getenv('DB_USER') ?: 'root';
            $pass   = getenv('MYSQLPASSWORD') ?: getenv('DB_PASS') ?: '';

            $dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4";

            self::$instance = new PDO(
                $dsn,
                $user,
                $pass,
                [
                    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES   => false,
                    PDO::ATTR_STRINGIFY_FETCHES  => false
                ]
            );

            // SAFE replacement for MYSQL_ATTR_INIT_COMMAND
            self::$instance->exec("SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci");
            self::$instance->exec("SET time_zone = '+05:00'");
        }

        return self::$instance;
    }
}