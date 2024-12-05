<?php
namespace App\Usuario\Domain;

class UsuarioNotFoundException extends \Exception
{
    public function __construct($message = "Usuario no encontrado", $code = 404, $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}