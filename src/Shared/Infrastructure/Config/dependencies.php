<?php
/**
 * Aquí controlamos la inyección de dependencias de nuestra aplicación.
 */

use App\Libro\Application\ActualizarLibro;
use App\Libro\Application\BuscarLibroEnApi;
use App\Libro\Application\CrearLibro;
use App\Libro\Application\EliminarLibro;
use App\Libro\Application\ObtenerLibro;
use App\Libro\Application\ObtenerLibros;
use App\Libro\Infrastructure\Http\Controllers\LibroController;
use App\Libro\Infrastructure\Persistence\MySQLLibroRepository;
use App\Libro\Infrastructure\Services\GoogleApiLibroFinder;

use App\Shared\Infrastructure\Http\Controllers\HomeController;
use App\Shared\Infrastructure\Middleware\ResponseFormatMiddleware;

use Psr\Container\ContainerInterface;
use Slim\Factory\AppFactory;
use Slim\App;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Slim\Middleware\ErrorMiddleware;

return [
    Logger::class => function(ContainerInterface $container) {
        $settings = $container->get('config');
        // Configurar Monolog
        $stream = new StreamHandler(__DIR__ . '/../../../../logs/app.log', $settings['logLevel']);
        $logger = new Logger('app');
        $logger->pushHandler($stream);
        return $logger;
    },
    MySQLLibroRepository::class => function (ContainerInterface $container) {
        // Obtenemos la configuración de la base de datos desde el índice que hemos asignado al contenedor 
        // al importar la configuración desde index.php
        $config = $container->get('config')['database']; 
        return new MySQLLibroRepository($config);
    },
    GoogleApiLibroFinder::class => function(ContainerInterface $container) {
        $config = $container->get('config')['api'];
        return new GoogleApiLibroFinder($config);
    },
    CrearLibro::class => function (ContainerInterface $container) {
        return new CrearLibro($container->get(MySQLLibroRepository::class));
    },
    ActualizarLibro::class => function(ContainerInterface $container) {
        return new ActualizarLibro($container->get(MySQLLibroRepository::class));
    },
    ObtenerLibro::class => function (ContainerInterface $container) {
        return new ObtenerLibro($container->get(MySQLLibroRepository::class));
    },
    EliminarLibro::class => function (ContainerInterface $container) {
        return new EliminarLibro($container->get(MySQLLibroRepository::class));
    },
    ObtenerLibros::class => function(ContainerInterface $container) {
        return new ObtenerLibros($container->get(MySQLLibroRepository::class));
    },
    BuscarLibroEnApi::class => function(ContainerInterface $container) {
        return new BuscarLibroEnApi($container->get(GoogleApiLibroFinder::class));
    },
    LibroController::class => function (ContainerInterface $container) {
        return new LibroController(
            $container->get(CrearLibro::class),
            $container->get(ActualizarLibro::class),
            $container->get(ObtenerLibro::class),
            $container->get(EliminarLibro::class),
            $container->get(BuscarLibroEnApi::class),
            $container->get(Twig::class),
            $container->get(Logger::class),
        );
    },
    HomeController::class => function (ContainerInterface $container) {
        return new HomeController(
            $container->get(ObtenerLibros::class),
            $container->get(Twig::class),
            $container->get(Logger::class),
        );
    },
    Twig::class => function (ContainerInterface $container) {
        $settings = $container->get('config');
        $cacheDir = $settings['twig']['cache_dir'];
        return Twig::create(__DIR__ . '/../templates', [
            'cache' => $cacheDir
        ]);
    },
    ResponseFormatMiddleware::class => function () {
        return new ResponseFormatMiddleware();
    },
    App::class => function (ContainerInterface $container) {
        $app = AppFactory::create();

        // Agregar Twig Middleware
        $app->add(TwigMiddleware::createFromContainer($app, Twig::class));

        // Agregar ResponseFormatMiddleware
        $app->add(ResponseFormatMiddleware::class);

        // Configurar el manejador de errores de Slim, en el cual incluimos 
        // la configuración para mostrar por pantalla los errores en desarrollo y para registrarlos en log
        $settings = $container->get('config');
        $errorMiddleware = new ErrorMiddleware(
            $app->getCallableResolver(),
            $app->getResponseFactory(),
            $settings['displayErrorDetails'],
            $settings['logErrors'],
            $settings['logErrorDetails'],
        );

        $app->add($errorMiddleware);

        return $app;
    }
];
