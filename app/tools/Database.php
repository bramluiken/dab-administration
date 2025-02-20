<?php

namespace App\Tools;

use Core\Error;

class Database {
    private \PDO $pdo;
    public function __construct() {
        $dbHost = '';
        $dbName = '';
        $dbPass = '';
        $dbPort = 0;
        $dbUser = '';
        $dsn = "mysql:host={$dbHost};port={$dbPort};dbname={$dbName};charset=utf8mb4";

        try {
            $this->pdo = new \PDO($dsn, $dbUser, $dbPass, [
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
            ]);
        } catch (\PDOException $e) {
            throw new Error(
                'system',
                "Database connection failed",
                $e->getMessage(),
                ['pdo_code' => $e->getCode()]
            );
        }
    }
}