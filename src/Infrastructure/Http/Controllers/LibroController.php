<?php
namespace App\Infrastructure\Http\Controllers;

use App\Application\Libro\ActualizarLibro;
use App\Application\Libro\CrearLibro;
use App\Application\Libro\ObtenerLibro;
use App\Application\Libro\EliminarLibro;
use App\Application\Libro\LibroRequest;
use App\Domain\Libro\LibroNotFoundException;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Slim\Views\Twig;

class LibroController extends Controller
{
    public function __construct(
        private CrearLibro $crearLibro,
        private ActualizarLibro $actualizarLibro,
        private ObtenerLibro $obtenerLibro,
        private EliminarLibro $eliminarLibro,
        Twig $twig,
    ) {
        parent::__construct($twig);
    }

    /**
     * Inserta o actualiza un libro
     *
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param array $args
     * @return ResponseInterface
     */
    public function store(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        try {
            $datos = $request->getParsedBody();
            $libroRequest = new LibroRequest(
                $datos['titulo'],
                $datos['autor'],
                $datos['isbn'],
                $datos['descripcion'],
                $datos['id'] ?? null
            );
    
            if ($datos['id'] && is_numeric($datos['id'])) {
                $libro = $this->actualizarLibro->execute($libroRequest);
            } else {
                $libro = $this->crearLibro->execute($libroRequest);
            }
            return $this->formatResponse($request, $response, ['libro' => $libro], null, '/', 303);
        } 
        catch (\Throwable $th) {
            return $this->formatResponse($request, $response, ['error' => $th->getMessage()], 'libro.crear.html.twig');
            return $response->withStatus(500);
        }
    }

    /**
     * Muestra el formulario para crear un libro
     *
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
    public function create(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        return $this->formatResponse($request, $response, null, 'libro.form.html.twig');
    }

    /**
     * Obtiene el libro solicitado para editarlo en el formulario
     *
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param array $args
     * @return ResponseInterface
     */
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

    /**
     * Muestra los detalles del libro solicitado por la URL
     *
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param array $args
     * @return ResponseInterface
     */
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

    /**
     * Elimina el libro especificado por la URL
     *
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param array $args
     * @return ResponseInterface
     */
    public function delete(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        try {
            // Comprobamos que existe el libro
            $libro = $this->obtenerLibro->execute($args['id']);
            $this->eliminarLibro->execute($args['id']);
            return $this->formatResponse($request, $response, null, null, '/', 303);
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