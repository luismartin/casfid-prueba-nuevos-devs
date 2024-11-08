<?php
namespace App\Infrastructure\Http\Controllers;

use App\Application\Libro\CrearLibro;
use App\Application\Libro\ObtenerLibro;
use App\Application\Libro\CrearLibroRequest;
use App\Domain\Libro\LibroNotFoundException;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Slim\Views\Twig;

class LibroController
{
    public function __construct(
        private CrearLibro $crearLibro,
        private ObtenerLibro $obtenerLibro,
        private Twig $twig,
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
            return $this->formatResponse($request, $response, $libro);
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
            return $this->formatResponse($request, $response, $libro);
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

    private function formatResponse(ServerRequestInterface $request, ResponseInterface $response, $libro): ResponseInterface
    {
        $format = $request->getAttribute('response_format');

        if ($format === 'json') {
            $response->getBody()->write(json_encode($libro->toArray()));
            return $response->withHeader('Content-Type', 'application/json');
        } else {
            return $this->twig->render($response, 'libro.html.twig', ['libro' => $libro]);
        }
    }
}