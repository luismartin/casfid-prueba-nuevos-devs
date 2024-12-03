<?php
namespace App\Libro\Application;

use App\Libro\Domain\Libro;
use App\Libro\Domain\LibroRepository;
use App\Libro\Domain\ISBN;

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