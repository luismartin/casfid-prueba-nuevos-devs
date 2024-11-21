<?php
namespace App\Domain\Libro;

interface LibroFinder
{
    public function search(string $search): array;
}