<?php
namespace App\Shared\Infrastructure\Http\Controllers;

use App\Libro\Application\ObtenerLibros;
use Monolog\Logger;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Slim\Views\Twig;

/**
 * Controlador de la página de inicio
 */
class HomeController extends Controller
{
    public function __construct(
        private ObtenerLibros $obtenerLibros,
        Twig $twig,
        Logger $logger,
    ) {
        parent::__construct($twig, $logger);
    }

    /**
     * Muestra la página de inicio con la lista de libros
     *
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     * @throws \Throwable
     */
    public function index(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        try {
            $libros = $this->obtenerLibros->execute();

            $output = [];
            foreach ($libros as $libro) {
                $output[] = $libro->toArray();
            }

            return $this->formatResponse($request, $response, ['libros' => $output], 'home.html.twig');
        } 
        catch (\Throwable $th) {
            $body = $response->getBody();
            $body->write(json_encode(['error' => $th->getMessage()]));
            return $response->withStatus(500);
        }
    }

}