<?php
namespace App\Application\Libro;

use App\Domain\Libro\LibroRepository;
use App\Domain\Libro\Libro;
use App\Domain\Shared\ISBN;

class ObtenerLibros
{
    public function __construct(
        private LibroRepository $libroRepository
    ) {}

    public function execute(): array
    {
        $libro = $this->libroRepository->all();
        $libros = [];
        foreach ($libro as $l) {
            $libro = new Libro(
                $l['titulo'], 
                $l['autor'], 
                new ISBN($l['isbn']), 
                $l['descripcion'], 
                $l['id']
            );
            $libros[] = $libro;
        }
        return $libros;
    }
}