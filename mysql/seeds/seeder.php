<?php
use Ramsey\Uuid\Uuid;

$uuid = Uuid::uuid4();

$host = 'mysql';
$db = 'test_db';
$user = 'test';
$pass = 'test';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}

$passwordHash = password_hash('1234', PASSWORD_BCRYPT);

$pdo->exec("INSERT INTO `usuarios` (`id`, `username`, `password`, `email`) VALUES ('$uuid', 'test', '$passwordHash', 'test@test.com')");
$pdo->exec("INSERT INTO `libros` (`titulo`, `autor`, `isbn`, `descripcion`) VALUES ('Example Book', 'Example Author', '1234567890123', 'This is an example description.')");

echo "Database seeded successfully.\n";