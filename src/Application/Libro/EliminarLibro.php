<?php
namespace App\Application\Libro;

use App\Domain\Libro\LibroRepository;

class EliminarLibro
{
    public function __construct(
        private LibroRepository $libroRepository
    ) {}

    public function execute(int $id): void
    {
        $this->libroRepository->delete($id);
    }
}