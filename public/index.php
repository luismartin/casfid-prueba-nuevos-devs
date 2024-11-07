<?php
use Slim\Container;
use Slim\App;

require_once __DIR__ . '/../vendor/autoload.php';

// Crear un contenedor DI (Dependency Injection) de PHP-DI
$container = new Container();

// Cargar las dependencias
$dependencies = require __DIR__ . '/../src/Infrastructure/Config/dependencies.php';
foreach ($dependencies as $key => $value) {
    $container[$key] = $value;
}

// Configurar Slim para que use el contenedor
$app = new App($container);

// Cargar las rutas de la aplicación
//(require __DIR__ . '/../src/Infrastructure/Config/routes.php')($app);
require __DIR__ . '/../src/Infrastructure/Config/routes.php';

// Ejecutar la aplicación
$app->run();