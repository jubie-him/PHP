<?php
namespace App;

use PDO;

class Database
{
    private static ?PDO $pdo = null;

    public static function getConnection(): PDO
    {
        if (self::$pdo === null) {
            $config = require __DIR__ . '/../config/database.php';
            $username = $config['username'] ?? null;
            $password = $config['password'] ?? null;
            self::$pdo = new PDO($config['dsn'], $username, $password);
            self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        return self::$pdo;
    }
}
