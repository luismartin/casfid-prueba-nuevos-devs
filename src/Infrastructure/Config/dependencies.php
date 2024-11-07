<?php
// dependencies.php
use App\Application\Libro\CrearLibro;
use App\Application\Libro\ObtenerLibro;
use App\Infrastructure\Http\Controllers\LibroController;
use App\Infrastructure\Persistence\MySQLLibroRepository;
use Psr\Container\ContainerInterface;

return [
    CrearLibro::class => function (ContainerInterface $container) {
        return new CrearLibro($container->get(MySQLLibroRepository::class));
    },
    ObtenerLibro::class => function (ContainerInterface $container) {
        return new ObtenerLibro($container->get(MySQLLibroRepository::class));
    },
    LibroController::class => function (ContainerInterface $container) {
        return new LibroController(
            $container->get(CrearLibro::class),
            $container->get(ObtenerLibro::class)
        );
    }
];
