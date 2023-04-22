<?php

$host = 'mysql';
$database = 'test_db';
$username = 'test';
$password = 'test';

/* Create a connection */
try {
    $dsn = "mysql:host=$host;dbname=$database;charset=utf8";
    $pdo = new \PDO($dsn, $username, $password);
    $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
} catch (\PDOException $e) {
    die($e->getMessage());
}

/* Create a table */
$pdo->query("
    CREATE TABLE IF NOT EXISTS `users` (
      `id` int NOT NULL AUTO_INCREMENT,
      `username` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
      `password` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
      `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
      `created_at` datetime NOT NULL,
      PRIMARY KEY (`id`),
      UNIQUE KEY `username` (`username`)
    ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
");

/* Insert an user */
$rowsNumber = $pdo
    ->query("SELECT COUNT(*) AS `rows_number` FROM `users`;")
    ->fetch(\PDO::FETCH_ASSOC)['rows_number'];

if ($rowsNumber == 0) {
    $now = (new \DateTime('now'))->format('Y-m-d H:i:s');
    $pdo->query("
        INSERT INTO `users` (`username`, `password`, `email`, `created_at`)
        VALUES ('John Doe', '1234', 'john.doe@example.com', '$now');
    ");
}

/* Get the user back */
$user = $pdo
    ->query("SELECT `username`, `email`, `created_at` FROM `users`;")
    ->fetch(\PDO::FETCH_ASSOC);


/* Print the user */
echo '<pre>';
print_r($user);
echo '</pre>';
