<?php

namespace pxgamer\YifyTorrents\Server;

use pxgamer\YifyTorrents\Config;

/**
 * Class Database
 */
class Database
{
    /**
     * @var \PDO|null
     */
    protected static $conn;

    /**
     * @return \PDO
     */
    public static function connect()
    {
        if (!is_a(self::$conn, '\\PDO')) {
            try {
                self::$conn = new \PDO(
                    Config\Database::DB_DSN,
                    Config\Database::DB_USER,
                    Config\Database::DB_PASS
                );
            } catch (\Exception $e) {
                Logger::log($e);
                die('Failed to connect to database.');
            }
        }

        return self::$conn;
    }
}
