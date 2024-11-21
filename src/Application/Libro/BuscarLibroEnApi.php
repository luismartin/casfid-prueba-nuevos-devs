<?php
namespace App\Application\Libro;

use App\Domain\Libro\LibroFinder;
use App\Domain\Libro\LibroNotFoundException;

class BuscarLibroEnApi
{
    public function __construct(private LibroFinder $libroFinder)
    {}

    public function execute(string $busqueda): array
    {
        $libros = [];
        foreach ($this->libroFinder->search($busqueda) as $libro) {
            $libros[] = $libro->toArray();
        }
        if (empty($libros)) {
            throw new LibroNotFoundException('No se encontraron libros');
        }
        return $libros;
    }
}