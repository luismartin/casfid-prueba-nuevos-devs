<?php
namespace App\Libro\Application;

use App\Libro\Domain\Libro;
use App\Libro\Domain\LibroRepository;
use App\Libro\Domain\ISBN;

/**
 * Caso de uso para crear un libro en el sistema
 */
class CrearLibro
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
     * Crea un libro en el sistema.
     * Obtiene un objeto LibroDTO y lo convierte en un objeto Libro para guardarlo en el repositorio.
     *
     * @param LibroDTO $libroDTO
     * @return LibroDTO Devuelve el objeto LibroDTO con el id recién asignado
     */
    public function execute(LibroDTO $libroDTO): LibroDTO
    {
        $id = $this->libroRepository->create(
            new Libro(
                $libroDTO->getTitulo(),
                $libroDTO->getAutor(),
                new ISBN($libroDTO->getIsbn()),
                $libroDTO->getDescripcion(),
                $libroDTO->getId(),
            )
        );
        return $libroDTO->setId($id);
    }
}