<?php
namespace App\Application\Libro;

use App\Domain\Libro\LibroFinder;
use App\Domain\Libro\LibroNotFoundException;

/**
 * Realiza la búsqueda de libros en una API externa
 */
class BuscarLibroEnApi
{
    public function __construct(
        /**
         * Servicio de dominio para la búsqueda de libros
         *
         * @var LibroFinder
         */
        private LibroFinder $libroFinder
    ){}

    /**
     * Realiza la búsqueda del libro en una API externa
     *
     * @param string $busqueda
     * @return array
     */
    public function execute(string $busqueda): array
    {
        $libros = [];
        foreach ($this->libroFinder->search($busqueda) as $libro) {
            $libros[] = $libro->toArray();
        }
        if (empty($libros)) {
            throw new LibroNotFoundException('No se encontraron libros');
        }
        return $libros;
    }
}