<?php
namespace App\Domain\Shared;

/**
 * DTO que representa el ID de un usuario
 * @todo Todavía no usado
 */
class UserId
{
    public function __construct(private int $id)
    {
        if ($id < 1) {
            throw new \InvalidArgumentException('ID de usuario inválido');
        }
    }

    public function __toString(): string
    {
        return (string) $this->id;
    }
}