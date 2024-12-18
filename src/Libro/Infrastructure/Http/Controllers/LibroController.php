<?php
namespace App\Libro\Infrastructure\Http\Controllers;

use App\Libro\Application\ActualizarLibro;
use App\Libro\Application\BuscarLibroEnApi;
use App\Libro\Application\CrearLibro;
use App\Libro\Application\ObtenerLibro;
use App\Libro\Application\EliminarLibro;
use App\Libro\Application\LibroDTO;
use App\Libro\Domain\LibroNotFoundException;
use App\Shared\Infrastructure\Http\Controllers\Controller;

use Monolog\Logger;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Slim\Views\Twig;

/**
 * Controlador para las peticiones relacionadas con los libros
 */
class LibroController extends Controller
{
    public function __construct(
        private CrearLibro $crearLibro,
        private ActualizarLibro $actualizarLibro,
        private ObtenerLibro $obtenerLibro,
        private EliminarLibro $eliminarLibro,
        private BuscarLibroEnApi $buscarLibroEnApi,
        Twig $twig,
        Logger $logger,
    ) {
        parent::__construct($twig, $logger);
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
            $libroDTO = new LibroDTO(
                $datos['titulo'],
                $datos['autor'],
                $datos['isbn'],
                $datos['descripcion'],
                $datos['id'] ?? null
            );
    
            if (isset($datos['id']) && is_numeric($datos['id'])) {
                $this->actualizarLibro->execute($libroDTO);
                $this->logger->info("Libro actualizado: " . $datos['id']);
            } else {
                $libroDTO = $this->crearLibro->execute($libroDTO);
                $this->logger->info("Libro creado: " . $libroDTO->getId(), $libroDTO->toArray());
            }
            return $this->formatResponse($request, $response, $libroDTO->toArray(), null, '/', 303);
        } 
        catch (\Throwable $th) {
            /*DEBUG(LMS)*/// echo "<pre>" . print_r($th->getMessage(), true) . "</pre>"; exit;
            return $this->formatResponse($request, $response, ['error' => $th->getMessage()], 'libro.crear.html.twig', null, 500);
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
            return $this->formatResponse($request, $response, ['error' => $th->getMessage()], null, null, 404);
        }
        catch (\Throwable $th) {
            return $this->formatResponse($request, $response, ['error' => $th->getMessage()], null, null, 500);
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
            return $this->formatResponse($request, $response, ['error' => $th->getMessage()], null, null, 404);
        }
        catch (\Throwable $th) {
            return $this->formatResponse($request, $response, ['error' => $th->getMessage()], null, null, 500);
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
            $this->logger->info("Libro eliminado: " . $libro->getId(), $libro->toArray());
            return $this->formatResponse($request, $response, null, null, '/', 303);
        } 
        catch (LibroNotFoundException $th) {
            return $this->formatResponse($request, $response, ['error' => $th->getMessage()], null, null, 404);
        }
        catch (\Throwable $th) {
            return $this->formatResponse($request, $response, ['error' => $th->getMessage()], null, null, 500);
        }
    }

    /**
     * Busca un libro en la API externa de búsqueda de libros
     *
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
    public function apiSearch(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        try {
            $busqueda = $request->getQueryParams()['search'] ?? null;
            $libros = $this->buscarLibroEnApi->execute($busqueda);
            $body = $response->getBody();
            $body->write(json_encode($libros));
            return $response->withHeader('Content-Type', 'application/json');
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