<?php
namespace App\Application\Libro;

use App\Domain\Libro\LibroRepository;
use App\Domain\Libro\Libro;
use App\Domain\Shared\ISBN;

class ObtenerLibros
{
    public function __construct(
        private LibroRepository $libroRepository
    ) {}

    /**
     * Obtiene todos los libros y los devuelve en un array de LibroDTO
     *
     * @return LibroDTO[]
     */
    public function execute(): array
    {
        $libros = $this->libroRepository->all();
        $libroDTOs = [];
        foreach ($libros as $libro) {
            $libro = new LibroDTO(...$libro->toArray());
            $libroDTOs[] = $libro;
        }
        return $libroDTOs;
    }
}