<?php
// dependencies.php

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

return [
    MySQLLibroRepository::class => function (ContainerInterface $container) {
        $config = $container->get('config.database'); // Obtener la configuración de la base de datos
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
    Twig::class => function () {
        return Twig::create(__DIR__ . '/../templates', ['cache' => false]);
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

        return $app;
    }
];
