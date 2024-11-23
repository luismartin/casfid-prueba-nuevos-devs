<?php
namespace App\Domain\Usuario;

/**
 * Repositorio de usuarios
 */
interface UsuarioRepository
{
    public function all(): array;
    public function find(int $id): ?Usuario;
    public function create(Usuario $usuario): void;
    public function update(Usuario $usuario): void;
    public function delete(int $id): void;
}