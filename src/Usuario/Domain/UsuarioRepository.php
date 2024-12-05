<?php
namespace App\Usuario\Domain;

/**
 * Repositorio de usuarios
 */
interface UsuarioRepository
{
    public function all(): array;
    public function login(string $username, string $password): ?Usuario;
    public function findByUsername(string $username): ?Usuario;
    public function findById(string $id): ?Usuario;
    public function create(Usuario $usuario): void;
    public function update(Usuario $usuario): void;
    public function delete(int $id): void;
}