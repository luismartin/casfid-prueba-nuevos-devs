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