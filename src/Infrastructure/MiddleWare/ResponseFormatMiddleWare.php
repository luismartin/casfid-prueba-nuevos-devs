<?php
namespace App\Infrastructure\Middleware;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;

/**
 * Middleware que extrae el formato de la respuesta (JSON o HTML) de la petición
 * @todo De momento no funciona. No se ejecuta el middleware
 */
class ResponseFormatMiddleware implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        //$host = $request->getUri()->getHost();
        //TODO: por algún motivo no está funcionando. No se ejecuta el middleware
        $query = $request->getQueryParams();
        $format = (isset($query['format']) && $query['format'] == 'json') ? 'json' : 'html';
        $request = $request->withAttribute('response_format', $format);
        return $handler->handle($request);
    }
}