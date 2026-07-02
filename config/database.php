<?php
// =============================================================================
// FILE: config/database.php
// PURPOSE: PDO connection singleton.
// =============================================================================

declare(strict_types=1);

class Database
{
    private static ?PDO $instance = null;

    // Prevent instantiation and cloning
    private function __construct() {}
    private function __clone() {}

    /**
     * Returns the shared PDO instance, creating it on first call.
     */
    public static function getConnection(): PDO
    {
        if (self::$instance === null) {

            // Railway MySQL environment variables
            // Falls back to DB_* variables if you use those instead.
            $host   = getenv('MYSQLHOST') ?: getenv('DB_HOST');
            $port   = getenv('MYSQLPORT') ?: getenv('DB_PORT');
            $dbname = getenv('MYSQLDATABASE') ?: getenv('DB_NAME');
            $user   = getenv('MYSQLUSER') ?: getenv('DB_USER');
            $pass   = getenv('MYSQLPASSWORD') ?: getenv('DB_PASS');

            // Local development fallback (optional)
            $host   = $host ?: 'localhost';
            $port   = $port ?: '3306';
            $dbname = $dbname ?: 'meter_testing_db';
            $user   = $user ?: 'root';
            $pass   = $pass ?: '';

            $dsn = sprintf(
                'mysql:host=%s;port=%s;dbname=%s;charset=utf8mb4',
                $host,
                $port,
                $dbname
            );

            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
                PDO::ATTR_STRINGIFY_FETCHES  => false,
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8mb4' COLLATE 'utf8mb4_unicode_ci', time_zone='+05:00'",
                // PDO::ATTR_PERSISTENT => true,
            ];

            self::$instance = new PDO($dsn, $user, $pass, $options);
        }

        return self::$instance;
    }
}