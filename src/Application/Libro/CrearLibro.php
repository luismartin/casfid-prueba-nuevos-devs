<?php
namespace App\Application\Libro;

use App\Domain\Libro\Libro;
use App\Domain\Libro\LibroRepository;
use App\Domain\Shared\ISBN;

class CrearLibro
{

    public function __construct(
        private LibroRepository $libroRepository
    ) {}

    public function execute(LibroRequest $libroRequest): Libro
    {
        $this->libroRepository->create(
            $libro = new Libro(
                $libroRequest->getTitulo(),
                $libroRequest->getAutor(),
                new ISBN($libroRequest->getIsbn()),
                $libroRequest->getDescripcion(),
                $libroRequest->getId(),
            )
        );
        return $libro;
    }
}