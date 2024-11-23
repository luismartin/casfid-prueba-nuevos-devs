<?php
namespace App\Application\Libro;

use App\Domain\Libro\Libro;
use App\Domain\Libro\LibroRepository;
use App\Domain\Shared\ISBN;

/**
 * Caso de uso para actualizar un libro
 */
class ActualizarLibro
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
     * Realiza la actualización de un libro
     *
     * @param LibroDTO $libro
     * @return void
     */
    public function execute(LibroDTO $libro): void
    {
        $this->libroRepository->update(
            new Libro(
                $libro->getTitulo(),
                $libro->getAutor(),
                new ISBN($libro->getIsbn()),
                $libro->getDescripcion(),
                $libro->getId()
            )
        );
    }
}