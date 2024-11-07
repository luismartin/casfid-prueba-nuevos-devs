<?php
namespace App\Domain\Shared;

class ISBN
{
    public function __construct(private string $isbn)
    {
        if (!preg_match('/^\d{13}$/', $isbn)) {
            throw new \InvalidArgumentException('ISBN inválido');
        }
    }

    public function __toString(): string
    {
        return $this->isbn;
    }
}