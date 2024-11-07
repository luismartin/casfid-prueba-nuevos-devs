<?php

namespace App\Domain\Libro;

use App\Domain\Shared\ISBN;
use App\Domain\Shared\Entity;

class Libro implements Entity
{

    private int $id;

    public function __construct(
        private string $titulo, 
        private string $autor, 
        private ISBN $isbn,
        private string $descripcion)
    {}

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'titulo' => $this->titulo,
            'autor' => $this->autor,
            'isbn' => $this->isbn,
            'descripcion' => $this->descripcion
        ];
    }
}