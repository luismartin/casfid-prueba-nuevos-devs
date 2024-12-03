<?php
namespace App\Libro\Application;

use App\Libro\Domain\LibroRepository;
use App\Libro\Domain\Libro;
use App\Libro\Domain\ISBN;

/**
 * Caso de uso para la obtención de todos los libros
 */
class ObtenerLibros
{
    public function __construct(
        /**
         * Repositorio de libros
         *
         * @var LibroRepository
         */
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