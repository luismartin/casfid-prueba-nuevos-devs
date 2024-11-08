<?php
use Slim\Factory\AppFactory;
use DI\Container;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;

require_once __DIR__ . '/../vendor/autoload.php';

// Crear un contenedor DI (Dependency Injection) de PHP-DI
$container = new Container();

// Cargar configuración de la base de datos
$databaseConfig = require __DIR__ . '/../config/database.php';
$container->set('config.database', $databaseConfig);

// Configurar Slim para que use el contenedor
AppFactory::setContainer($container);
$app = AppFactory::create();

// Cargar las dependencias
$dependencies = require __DIR__ . '/../src/Infrastructure/Config/dependencies.php';
foreach ($dependencies as $key => $value) {
    $container->set($key, $value);
}

// Configurar Twig
$container->set('view', function () {
    return Twig::create(__DIR__ . '/../src/Infrastructure/templates', ['cache' => false]);
});

// Agregar Twig Middleware
$app->add(TwigMiddleware::createFromContainer($app, 'view'));

// Cargar las rutas de la aplicación
//(require __DIR__ . '/../src/Infrastructure/Config/routes.php')($app);
require __DIR__ . '/../src/Infrastructure/Config/routes.php';

// Ejecutar la aplicación
$app->run();