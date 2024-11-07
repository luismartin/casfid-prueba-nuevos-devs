<?php

namespace App\Domain\Usuario;

use App\Domain\Shared\UserId;

class Usuario
{
    public function __construct(
        private UserId $id,
        private string $nombre,
        private string $email,
        private string $password
    ) {
    }
}