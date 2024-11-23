<?php
namespace App\Domain\Shared;

/**
 * Objeto Value Object para encapsular la validación de un ISBN de 13 dígitos
 */
class ISBN
{
    public function __construct(private string $isbn)
    {
        if (!preg_match('/^\d{13}$/', $isbn)) {
            throw new \InvalidArgumentException('ISBN inválido: ' . $isbn);
        }
        $this->isbn = $isbn;
    }

    /**
     * Devuelve el valor de cadena del ISBN
     *
     * @return string
     */
    public function __toString(): string
    {
        return $this->isbn;
    }
}