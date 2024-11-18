<?php
namespace App\Application\Libro;

class CrearLibroRequest 
{
    public function __construct(
        private string $titulo,
        private string $autor,
        private string $isbn,
        private string $descripcion,
        private ?int $id = null
    )
    {}

    public function getTitulo(): string
    {
        return $this->titulo;
    }

    public function getAutor(): string
    {
        return $this->autor;
    }

    public function getIsbn(): string
    {
        return $this->isbn;
    }

    public function getDescripcion(): string
    {
        return $this->descripcion;
    }

    public function getId(): ?int
    {
        return $this->id;
    }
}