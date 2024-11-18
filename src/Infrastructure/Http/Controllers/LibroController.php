<?php
namespace App\Infrastructure\Http\Controllers;

use App\Application\Libro\CrearLibro;
use App\Application\Libro\ObtenerLibro;
use App\Application\Libro\CrearLibroRequest;
use App\Domain\Libro\Libro;
use App\Domain\Libro\LibroNotFoundException;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Slim\Views\Twig;

class LibroController extends Controller
{
    public function __construct(
        private CrearLibro $crearLibro,
        private ObtenerLibro $obtenerLibro,
        Twig $twig,
    ) {
        parent::__construct($twig);
    }

    public function store(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        try {
            $datos = $request->getParsedBody();
            $libroRequest = new CrearLibroRequest(
                $datos['titulo'],
                $datos['autor'],
                $datos['isbn'],
                $datos['descripcion'],
                $args['id'] ?? null
            );
    
            $libro = $this->crearLibro->execute($libroRequest);    
            return $this->formatResponse($request, $response, ['libro' => $libro], null, '/', 303);
        } 
        catch (\Throwable $th) {
            return $this->formatResponse($request, $response, ['error' => $th->getMessage()], 'libro.crear.html.twig');
            return $response->withStatus(500);
        }
    }

    public function create(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        return $this->formatResponse($request, $response, null, 'libro.form.html.twig');
    }

    public function edit(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        try {
            $libro = $this->obtenerLibro->execute($args['id']);
            return $this->formatResponse($request, $response, $libro->toArray(), 'libro.form.html.twig');
        } 
        catch (LibroNotFoundException $th) {
            return $this->formatResponse($request, $response, ['error' => $th->getMessage()]);
            return $response->withStatus(404);
        }
        catch (\Throwable $th) {
            return $this->formatResponse($request, $response, ['error' => $th->getMessage()]);
            return $response->withStatus(500);
        }
    }

    public function show(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        try {
            $libro = $this->obtenerLibro->execute($args['id']);
            return $this->formatResponse($request, $response, $libro->toArray(), 'libro.html.twig');
        } 
        catch (LibroNotFoundException $th) {
            return $this->formatResponse($request, $response, ['error' => $th->getMessage()]);
            return $response->withStatus(404);
        }
        catch (\Throwable $th) {
            return $this->formatResponse($request, $response, ['error' => $th->getMessage()]);
            return $response->withStatus(500);
        }
    }
}