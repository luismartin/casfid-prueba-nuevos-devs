<?php
namespace App\Usuario\Application;

class UsuarioDTO
{

    public function __construct(
        private string|null $id, 
        private string $nombre, 
        private string|null $email, 
        private string $password)
    {}

    public function getId(): string
    {
        return $this->id;
    }

    public function getNombre(): string
    {
        return $this->nombre;
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