<?php
namespace App\Shared\Domain;

/**
 * DTO que representa el ID de un usuario
 * @todo Todavía no usado
 */
class UserId
{
    public function __construct(private string $id)
    {
        if (strlen($this->id) !== 36) {
            throw new \InvalidArgumentException('ID de usuario inválido');
        }
    }

    public function __toString(): string
    {
        return $this->id;
    }
}