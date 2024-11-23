<?php
namespace App\Domain\Libro;

/**
 * Excepción para cuando un libro no se encuentra
 */
class LibroNotFoundException extends \Exception
{
    public function __construct()
    {
        parent::__construct('Libro no encontrado');
    }
}