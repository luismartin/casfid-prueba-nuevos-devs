<?php

namespace App\Infrastructure\Persistence;

use PDO;
use App\Domain\Libro\Libro;
use App\Domain\Libro\LibroRepository;

class MySQLLibroRepository implements LibroRepository
{
    protected $pdo;

    public function __construct(array $config)
    {
        $dsn = "mysql:host={$config['host']};dbname={$config['database']};charset=utf8";
        $this->pdo = new PDO($dsn, $config['username'], $config['password']);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function all(): array
    {
        $stmt = $this->pdo->query('SELECT * FROM libros');
        return $stmt->fetchAll();
    }

    public function find(int $id): Libro
    {
        $stmt = $this->pdo->prepare('SELECT * FROM libros WHERE id = :id');
        $stmt->execute(['id' => $id]);
        $datos = $stmt->fetch();
        return new Libro($datos['id'], $datos['titulo'], $datos['autor'], $datos['isbn'], $datos['descripcion']);
    }

    public function create(Libro $libro): void
    {
        $stmt = $this->pdo->prepare('INSERT INTO libros (titulo, autor, isbn, descripcion) VALUES (:titulo, :autor, :isbn, :descripcion)');
        $stmt->execute($libro->toArray());
    }

    public function update(Libro $libro): void
    {
        $stmt = $this->pdo->prepare('UPDATE libros SET titulo = :titulo, autor = :autor, isbn = :isbn, descripcion = :descripcion WHERE id = :id');
        $stmt->execute($libro->toArray());
    }

    public function delete(int $id): void
    {
        $stmt = $this->pdo->prepare('DELETE FROM libros WHERE id = :id');
        $stmt->execute(['id' => $id]);
    }
}