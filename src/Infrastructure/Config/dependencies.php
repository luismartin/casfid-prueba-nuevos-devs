<?php
/**
 * Aquí controlamos la inyección de dependencias de nuestra aplicación.
 */

use App\Application\Libro\ActualizarLibro;
use App\Application\Libro\CrearLibro;
use App\Application\Libro\EliminarLibro;
use App\Application\Libro\ObtenerLibro;
use App\Application\Libro\ObtenerLibros;
use App\Infrastructure\Http\Controllers\LibroController;
use App\Infrastructure\Http\Controllers\HomeController;
use App\Infrastructure\Persistence\MySQLLibroRepository;
use Psr\Container\ContainerInterface;
use Slim\Factory\AppFactory;
use Slim\App;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;
use App\Infrastructure\Middleware\ResponseFormatMiddleware;
use Slim\Middleware\ErrorMiddleware;

return [
    MySQLLibroRepository::class => function (ContainerInterface $container) {
        // Obtenemos la configuración de la base de datos desde el índice que hemos asignado al contenedor 
        // al importar la configuración desde index.php
        $config = $container->get('config')['database']; 
        return new MySQLLibroRepository($config);
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
    LibroController::class => function (ContainerInterface $container) {
        return new LibroController(
            $container->get(CrearLibro::class),
            $container->get(ActualizarLibro::class),
            $container->get(ObtenerLibro::class),
            $container->get(EliminarLibro::class),
            $container->get(Twig::class),
        );
    },
    HomeController::class => function (ContainerInterface $container) {
        return new HomeController(
            $container->get(ObtenerLibros::class),
            $container->get(Twig::class),
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
