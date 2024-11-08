<?php
namespace App\Domain\Libro;

class LibroNotFoundException extends \Exception
{
    public function __construct()
    {
        parent::__construct('Libro no encontrado');
    }
}