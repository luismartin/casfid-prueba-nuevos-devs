<?php
namespace App\Libro\Application;

/**
 * Esta clase se utiliza como un Data Transfer Object (DTO) para transferir datos
 * entre la capa de infraestructura (controladores) y la capa de aplicación.
 * Proporciona una representación básica de una entidad libro sin lógica de negocio.
 * De esta manera, se evita acoplar la infraestructura con la lógica de negocio.
 * @package App\Libro\Application
 */
class LibroDTO 
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

    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    /**
     * Devuelve todos los atributos del objeto en un array
     *
     * @return array
     */
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