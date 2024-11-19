<?php
use PHPUnit\Framework\TestCase;
use App\Domain\Libro\Libro;
use App\Domain\Shared\ISBN;

class LibroTest extends TestCase
{
    public function testLibroCreation()
    {
        $isbn = new ISBN('1234567890123');
        $libro = new Libro('Título', 'Autor', $isbn, 'Descripción');

        $libro_array = $libro->toArray();

        $this->assertEquals('Título', $libro_array['titulo']);
        $this->assertEquals('Autor', $libro_array['autor']);
        $this->assertEquals($isbn, $libro_array['isbn']);
        $this->assertEquals('Descripción', $libro_array['descripcion']);
    }
}