<?php
namespace App\Shared\Domain;

/**
 * Interfaz para las entidades de dominio del sistema
 */
interface Entity
{
    /**
     * Convierte los atributos de la entidad en un array
     *
     * @return array
     */
    public function toArray(): array;

    /**
     * Obtiene el id de la entidad, si existe
     *
     * @return integer|string|null
     */
    public function getId(): int|string|null;

    /**
     * Asigna el id de la entidad
     *
     * @param integer|string $id
     * @return void
     */
    public function setId(int|string $id): void;
}