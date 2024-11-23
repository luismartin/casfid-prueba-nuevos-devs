<?php
namespace App\Infrastructure\Http\Controllers;

use App\Application\Libro\ObtenerLibros;
use Monolog\Logger;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Slim\Views\Twig;

class HomeController extends Controller
{
    public function __construct(
        private ObtenerLibros $obtenerLibros,
        Twig $twig,
        Logger $logger,
    ) {
        parent::__construct($twig, $logger);
    }

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