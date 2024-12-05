<?php

namespace App\Libro\Domain;

use App\Libro\Domain\ISBN;
use App\Shared\Domain\Entity;

/**
 * Clase que representa la endidad de dominio Libro
 */
class Libro implements Entity
{

    public function __construct(
        private string $titulo, 
        private string $autor, 
        private ISBN $isbn,
        private string $descripcion,
        private ?int $id = null)
    {}

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'titulo' => $this->titulo,
            'autor' => $this->autor,
            'isbn' => $this->isbn->__toString(),
            'descripcion' => $this->descripcion
        ];
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int|string $id): void
    {
        $this->id = $id;
    }
}