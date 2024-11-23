<?php

namespace App\Domain\Usuario;

use App\Domain\Shared\Entity;
use App\Domain\Shared\UserId;

/**
 * Undocumented class
 * @todo No conforma correctamente con la interfaz Entity
 */
class Usuario // implements Entity
{
    public function __construct(
        private UserId $id,
        private string $nombre,
        private string $email,
        private string $password
    ) {
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id->__toString(),
            'nombre' => $this->nombre,
            'email' => $this->email,
            'password' => $this->password
        ];
    }

    /*public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(UserId $id): void
    {
        $this->id = $id;
    }*/
}