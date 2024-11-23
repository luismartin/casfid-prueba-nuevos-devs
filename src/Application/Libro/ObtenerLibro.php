<?php
namespace App\Application\Libro;

use App\Domain\Libro\LibroRepository;
use App\Domain\Libro\Libro;
use App\Domain\Libro\LibroNotFoundException;

class ObtenerLibro
{
    public function __construct(
        private LibroRepository $libroRepository
    ) {}

    public function execute(int $id): LibroDTO
    {
        $libro = $this->libroRepository->find($id);
        if ($libro === null) {
            throw new LibroNotFoundException();
        }
        return new LibroDTO(...$libro->toArray());
    }
}