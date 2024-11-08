<?php
namespace App\Infrastructure\Middleware;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;

class ResponseFormatMiddleware implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $host = $request->getUri()->getHost();
        $format = (strpos($host, 'api.') === 0) ? 'json' : 'html';
        $request = $request->withAttribute('response_format', $format);
        return $handler->handle($request);
    }
}