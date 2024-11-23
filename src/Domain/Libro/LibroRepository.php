<?php

namespace App\Domain\Libro;

interface LibroRepository
{
    /**
     * Obtiene todos los libros.
     * Devuelve un array de instancias de la entidad Libro
     *
     * @return Libro[]
     */
    public function all(): array;

    /**
     * Busca un libro por su id y lo entrega
     *
     * @param integer $id
     * @return Libro
     * @throws LibroNotFoundException
     */
    public function find(int $id): Libro;

    /**
     * Crea un nuevo libro
     *
     * @param Libro $libro
     * @return integer
     * @throws \Exception
     */
    public function create(Libro $libro): int;

    /**
     * Actualiza un libro
     *
     * @param Libro $libro
     * @return void
     * @throws LibroNotFoundException, 
     * @throws \Exception
     */
    public function update(Libro $libro): void;

    /**
     * Elimina un libro
     *
     * @param integer $id
     * @return void
     * @throws \Exception
     */
    public function delete(int $id): void;
}