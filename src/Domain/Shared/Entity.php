<?php
namespace App\Domain\Shared;

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
     * @return integer|null
     */
    public function getId(): ?int;

    /**
     * Asigna el id de la entidad
     *
     * @param integer $id
     * @return void
     */
    public function setId(int $id): void;
}