<?php

namespace App\Infrastructure\Persistence;

use PDO;
use App\Domain\Libro\Libro;
use App\Domain\Libro\LibroNotFoundException;
use App\Domain\Libro\LibroRepository;
use App\Domain\Shared\ISBN;

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
        if (empty($datos)) {
            throw new LibroNotFoundException('Libro no encontrado');
        }
        return new Libro(
            $datos['titulo'], 
            $datos['autor'], 
            new ISBN($datos['isbn']), 
            $datos['descripcion'],
            $id,
        );
    }

    public function create(Libro $libro): void
    {
        $stmt = $this->pdo->prepare('INSERT INTO libros (id, titulo, autor, isbn, descripcion) VALUES (:id, :titulo, :autor, :isbn, :descripcion)');
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