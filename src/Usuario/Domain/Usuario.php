<?php

namespace App\Usuario\Domain;

use App\Shared\Domain\Entity;
use App\Shared\Domain\UserId;

/**
 * Undocumented class
 * @todo No conforma correctamente con la interfaz Entity
 */
class Usuario implements Entity
{
    public function __construct(
        private UserId $id,
        private string $username,
        private string $email,
        private string $password
    ) {
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id->__toString(),
            'username' => $this->username,
            'email' => $this->email,
            'password' => '********' // Ofuscamos la contraseña
        ];
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string|int $id): void
    {
        $this->id = new UserId($id);
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }
}