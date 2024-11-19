<?php
namespace App\Application\Libro;

use App\Domain\Libro\Libro;
use App\Domain\Libro\LibroRepository;
use App\Domain\Shared\ISBN;

class ActualizarLibro
{
    public function __construct(
        private LibroRepository $libroRepository
    ) {}

    public function execute(LibroRequest $libro): void
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