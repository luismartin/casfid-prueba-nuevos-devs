<?php
namespace App\Infrastructure\Http\Controllers;

use App\Domain\Libro\Libro;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Slim\Views\Twig;

class Controller
{

    public function __construct(
        protected Twig $twig
    ) {}

    protected function formatResponse(ServerRequestInterface $request, ResponseInterface $response, $data = null, $template = null, $location = null, $status = null): ResponseInterface
    {
        $format = $request->getAttribute('response_format');
        
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