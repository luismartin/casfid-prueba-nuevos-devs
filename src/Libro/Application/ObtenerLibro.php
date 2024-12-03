<?php
namespace App\Libro\Application;

use App\Libro\Domain\LibroRepository;
use App\Libro\Domain\Libro;
use App\Libro\Domain\LibroNotFoundException;

/**
 * Caso de uso para la obtención de un libro desde el repositorio
 */
class ObtenerLibro
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
     * Ejecuta la búsqueda de un libro por su id
     *
     * @param integer $id
     * @return LibroDTO
     */
    public function execute(int $id): LibroDTO
    {
        $libro = $this->libroRepository->find($id);
        if ($libro === null) {
            throw new LibroNotFoundException();
        }
        return new LibroDTO(...$libro->toArray());
    }
}