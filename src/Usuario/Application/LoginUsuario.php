<?php
namespace App\Usuario\Application;

use App\Usuario\Domain\Usuario;
use App\Usuario\Domain\UsuarioRepository;

class LoginUsuario
{

    public function __construct(private UsuarioRepository $repository)
    {}

    public function execute(UsuarioDTO $usuarioDTO): Usuario
    {
        $password = password_hash($usuarioDTO->getPassword(), PASSWORD_BCRYPT);
        $usuario = $this->repository->login($usuarioDTO->getNombre(), $password);
        //TODO: guardar en sesión
        return $usuario;
    }
}