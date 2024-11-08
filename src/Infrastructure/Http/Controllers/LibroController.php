<?php
namespace App\Infrastructure\Http\Controllers;

use App\Application\Libro\CrearLibro;
use App\Application\Libro\ObtenerLibro;
use App\Application\Libro\CrearLibroRequest;
use App\Domain\Libro\LibroNotFoundException;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

class LibroController
{
    public function __construct(
        private CrearLibro $crearLibro,
        private ObtenerLibro $obtenerLibro
    ) {}

    public function store(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        try {
            $libro = new CrearLibroRequest(
                $args['titulo'],
                $args['autor'],
                $args['isbn'],
                $args['descripcion'],
            );
    
            $this->crearLibro->execute($libro);
    
            return $response->withStatus(201);
        } 
        catch (\Throwable $th) {
            $body = $response->getBody();
            $body->write(json_encode(['error' => $th->getMessage()]));
            return $response->withStatus(500);
        }
    }

    public function show(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        try {
            $libro = $this->obtenerLibro->execute($args['id']);

            $body = $response->getBody();
            $body->write(json_encode($libro));
            return $response->withStatus(200);
        } 
        catch (LibroNotFoundException $th) {
            $body = $response->getBody();
            $body->write(json_encode(['error' => $th->getMessage()]));
            return $response->withStatus(404);
        }
        catch (\Throwable $th) {
            $body = $response->getBody();
            $body->write(json_encode(['error' => $th->getMessage()]));
            return $response->withStatus(500);
        }
    }
}