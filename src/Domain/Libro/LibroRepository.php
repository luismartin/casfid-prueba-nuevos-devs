<?php

namespace App\Domain\Libro;

interface LibroRepository
{
    public function all(): array;
    public function find(int $id): ?Libro;
    public function create(Libro $libro): void;
    public function update(Libro $libro): void;
    public function delete(int $id): void;
}