<?php
namespace App\Usuario\Infrastructure\Persistence;

use App\Shared\Domain\UserId;
use App\Usuario\Domain\Usuario;
use App\Usuario\Domain\UsuarioNotFoundException;
use App\Usuario\Domain\UsuarioRepository;

use PDO;

class MySQLUsuarioRepository implements UsuarioRepository
{
    private $pdo;

    public function __construct($config)
    {
        $dsn = "mysql:host={$config['host']};dbname={$config['database']};charset=utf8";
        $this->pdo = new PDO($dsn, $config['username'], $config['password']);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function all(): array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM usuarios');
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function login(string $username, string $password): ?Usuario
    {
        $stmt = $this->pdo->prepare('SELECT * FROM usuarios WHERE username = :username');
        $stmt->execute(['username' => $username]);
        $usuario = $stmt->fetch();
        if ($usuario && $usuario['password'] === $password) {
            return new Usuario(
                new UserId($usuario['id']), 
                $usuario['username'], 
                $usuario['email'], 
                $usuario['password']
            );
        }
        throw new UsuarioNotFoundException('Usuario no encontrado');
    }

    public function findById(string $id): ?Usuario
    {
        $stmt = $this->pdo->prepare('SELECT * FROM usuarios WHERE id = :id');
        $stmt->execute(['id' => $id]);
        $usuario = $stmt->fetch();
        if ($usuario) {
            return new Usuario(
                new UserId($usuario['id']), 
                $usuario['username'], 
                $usuario['email'], 
                $usuario['password']
            );
        }
        throw new UsuarioNotFoundException('Usuario no encontrado');
    }

    public function findByUsername(string $username): ?Usuario
    {
        $stmt = $this->pdo->prepare('SELECT * FROM usuarios WHERE username = :username');
        $stmt->execute(['username' => $username]);
        $usuario = $stmt->fetch();
        if ($usuario) {
            return new Usuario(
                new UserId($usuario['id']), 
                $usuario['username'], 
                $usuario['email'], 
                $usuario['password']
            );
        }
        throw new UsuarioNotFoundException('Usuario no encontrado');
    }

    public function create(Usuario $usuario): void
    {
        $stmt = $this->pdo->prepare('INSERT INTO usuarios (id, username, email, password) VALUES (:id, :username, :email, :password)');
        $stmt->execute([
            'id' => $usuario->getId(),
            'username' => $usuario->getUsername(),
            'email' => $usuario->getEmail(),
            'password' => $usuario->getPassword()
        ]);
    }

    public function update(Usuario $usuario): void
    {
        $stmt = $this->pdo->prepare('UPDATE usuarios SET email = :email, password = :password WHERE id = :id');
        $stmt->execute([
            'email' => $usuario->getEmail(),
            'password' => $usuario->getPassword(),
            'id' => $usuario->getId()
        ]);
    }

    public function delete(int $id): void
    {
        $stmt = $this->pdo->prepare('DELETE FROM usuarios WHERE id = :id');
        $stmt->execute(['id' => $id]);
    }
}