<?php

namespace App\Infrastructure\Persistence;

use PDO;

class MySQLRepository
{
    protected $pdo;

    public function __construct(array $config)
    {
        $dsn = "mysql:host={$config['host']};dbname={$config['database']};charset=utf8";
        $this->pdo = new PDO($dsn, $config['username'], $config['password']);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
}