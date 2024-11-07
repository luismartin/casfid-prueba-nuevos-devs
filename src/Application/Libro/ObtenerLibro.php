<?php
namespace App\Application\Libro;

use App\Domain\Libro\LibroRepository;

class ObtenerLibro
{
    public function __construct(
        private LibroRepository $libroRepository
    ) {}

    public function execute(int $id): array
    {
        $libro = $this->libroRepository->find($id);
        return $libro->toArray();
    }
}