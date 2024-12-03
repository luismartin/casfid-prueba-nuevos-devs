<?php
namespace App\Libro\Domain;

/**
 * Servicio de dominio para buscar libros externamente
 */
interface LibroFinder
{
    /**
     * Devuelve un array de libros que coincidan con la búsqueda
     *
     * @param string $search
     * @return Libro[]
     * @throws LibroNotFoundException
     * @throws \Exception
     */
    public function search(string $search): array;
}