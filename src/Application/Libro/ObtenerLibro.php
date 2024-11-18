<?php
namespace App\Application\Libro;

use App\Domain\Libro\LibroRepository;
use App\Domain\Libro\Libro;

class ObtenerLibro
{
    public function __construct(
        private LibroRepository $libroRepository
    ) {}

    public function execute(int $id): Libro
    {
        $libro = $this->libroRepository->find($id);
        return $libro;
    }
}