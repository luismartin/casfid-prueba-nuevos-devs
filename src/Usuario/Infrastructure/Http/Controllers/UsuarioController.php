<?php
namespace App\Usuario\Infrastructure\Http\Controllers;

use App\Usuario\Application\LoginUsuario;
use App\Usuario\Application\UsuarioDTO;
use App\Usuario\Domain\UsuarioNotFoundException;
use App\Shared\Infrastructure\Http\Controllers\Controller;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

use Slim\Views\Twig;
use Monolog\Logger;
use PDO;
use PDOException;
use Ramsey\Uuid\Uuid;

class UsuarioController extends Controller
{

    public function __construct(
        private LoginUsuario $loginUsuario,
        protected Twig $twig,
        protected Logger $logger,
    ) {
    }

    public function login(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        return $this->twig->render($response, 'usuario.login.twig');
    }

    public function dologin(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        try {

            $datos = $request->getParsedBody();
            $usuarioDTO = new UsuarioDTO(
                $datos['id'] ?? Uuid::uuid4(),
                $datos['usuario'],
                null,
                $datos['password'],
            );

            $usuario = $this->loginUsuario->execute($usuarioDTO);
            $this->logger->info("Usuario logueado: " . $usuario->getUsername(), $usuario->toArray());
            return $this->formatResponse($request, $response, $usuario, null, '/', 302);
        } 
        catch (UsuarioNotFoundException $e) {
            return $this->formatResponse($request, $response, ['error' => $e->getMessage()], null, '/usuarios/login', 302);
        }
        catch (PDOException $e) {
            $this->logger->error($e->getMessage());
            return $this->formatResponse($request, $response, null, 'Error en base de datos al hacer login', 500);
        }
        catch (\Exception $e) {
            $this->logger->error($e->getMessage());
            return $this->formatResponse($request, $response, null, 'Error inesperado al hacer login', 500);
        }
    }
}