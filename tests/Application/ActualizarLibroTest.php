<?php

namespace Tests\Libro\Application;

use App\Libro\Application\ActualizarLibro;
use App\Libro\Application\LibroDTO;
use App\Libro\Domain\LibroRepository;
use App\Libro\Domain\Libro;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\MockObject\MockObject;

/**
 * Test del caso de uso ActualizarLibro
 */
class ActualizarLibroTest extends TestCase
{
    public function testExecute()
    {
        // Crear un mock del repositorio
        /** @var LibroRepository|MockObject $libroRepository */
        $libroRepository = $this->createMock(LibroRepository::class);

        // Configurar el mock para esperar una llamada al método update
        $libroRepository->expects($this->once())
            ->method('update')
            ->with($this->isInstanceOf(Libro::class));

        // Crear una instancia del caso de uso ActualizarLibro
        $actualizarLibro = new ActualizarLibro($libroRepository);

        // Crear un objeto LibroRequest con datos de prueba
        $libroDTO = new LibroDTO(
            'Título actualizado',
            'Autor actualizado',
            '1234567890123',
            'Descripción actualizada',
            1 // ID del libro a actualizar
        );

        // Ejecutar el caso de uso
        $actualizarLibro->execute($libroDTO);
    }
}