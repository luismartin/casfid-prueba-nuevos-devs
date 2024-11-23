<?php
namespace App\Infrastructure\Http\Controllers;

use Monolog\Logger;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Slim\Views\Twig;

/**
 * Controlador base de la aplicación
 */
class Controller
{

    public function __construct(
        protected Twig $twig,
        protected Logger $logger,
    ) {}

    /**
     * Formatea la respuesta en función del formato de la petición
     *
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param array|null $data Datos a devolver en JSON o a pasar a la plantilla, dependiendo del formato
     * @param string|null $template Plantilla a renderizar en caso de que el formato sea HTML
     * @param string|null $location URL a la que redirigir en caso de que el formato sea HTML
     * @param integer|null $status Código de estado de la respuesta
     * @return ResponseInterface
     */
    protected function formatResponse(ServerRequestInterface $request, ResponseInterface $response, $data = null, $template = null, $location = null, $status = null): ResponseInterface
    {
        // TODO: No se ejecuta el middleware que extrae el formato de la respuesta (JSON o HTML), 
        // así que lo comentamos y obtenemos el formato directamente de la petición
        //$format = $request->getAttribute('response_format');
        $format = $request->getQueryParams()['format'] ?? 'html';
        
        $data = $data ?? [];
        if ($status) {
            $response = $response->withStatus($status);
        }
        if ($format === 'json') {
            $body = $response->getBody();
            $body->write(json_encode($data));
            return $response->withHeader('Content-Type', 'application/json');
        } else {
            if ($location) {
                return $response->withHeader('Location', $location);
            }
            $template = $template ?? 'home.html.twig';
            return $this->twig->render($response, $template, $data);
        }
    }
}