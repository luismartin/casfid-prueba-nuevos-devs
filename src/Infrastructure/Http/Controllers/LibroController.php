<?php
namespace App\Infrastructure\Http\Controllers;

use App\Application\Libro\CrearLibro;
use App\Application\Libro\ObtenerLibro;
use App\Application\Libro\CrearLibroRequest;

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
        $libro = new CrearLibroRequest(
            $args['titulo'],
            $args['autor'],
            $args['isbn'],
            $args['descripcion'],
        );

        $this->crearLibro->execute($libro);

        return $response->withStatus(201);
    }

    public function show(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $libro = $this->obtenerLibro->execute($args['id']);

        $body = $response->getBody();
        $body->write(json_encode($libro));
        return $response->withStatus(200);
    }
}