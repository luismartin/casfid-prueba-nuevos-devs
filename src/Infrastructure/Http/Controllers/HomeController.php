<?php
namespace App\Infrastructure\Http\Controllers;

use App\Application\Libro\ObtenerLibros;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

class HomeController
{
    public function __construct(
        private ObtenerLibros $obtenerLibros
    ) {}

    public function index(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        try {
            $libros = $this->obtenerLibros->execute();

            $output = [];
            foreach ($libros as $libro) {
                $output[] = $libro->toArray();
            }

            $body = $response->getBody();
            $body->write(json_encode($output));
            return $response->withStatus(200);
        } 
        catch (\Throwable $th) {
            $body = $response->getBody();
            $body->write(json_encode(['error' => $th->getMessage()]));
            return $response->withStatus(500);
        }
    }

}