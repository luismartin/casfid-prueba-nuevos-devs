<?php
namespace App\Libro\Application;

use App\Libro\Domain\LibroRepository;

/**
 * Elimina un libro del sistema
 */
class EliminarLibro
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
     * Ejecuta la eliminación del libro especificado por su id del sistema
     *
     * @param int $id
     * @return void
     */
    public function execute(int $id): void
    {
        $this->libroRepository->delete($id);
    }
}