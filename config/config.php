<?php

return [
    'database'  => [
        'host' => 'mysql',
        'database' => 'test_db',
        'username' => 'test',
        'password' => 'test',
    ],
    'twig' => [
        'cache_dir' => getenv('APP_ENV') === 'development' ? false : __DIR__ . '/../cache/twig', // Desactivar la caché durante el desarrollo
    ],
    // Mostrar errores en pantalla
    'displayErrorDetails' => getenv('APP_ENV') === 'development', // Cambiar a false en producción
    // Registrar errores en log
    'logErrors' => true,
    // Mostrar detalles de los errores (traza)
    'logErrorDetails' => true,
];