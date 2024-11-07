<?php
namespace App\Application\Libro;

use App\Domain\Libro\Libro;
use App\Domain\Libro\LibroRepository;

class ActualizarLibro
{
    public function __construct(
        private Libro $libro
    ) {}

    public function execute(LibroRepository $libro): void
    {
        $libro->update($this->libro);
    }
}