<?php
/**
 * Enrutador de la aplicación
 */

use App\Libro\Infrastructure\Http\Controllers\LibroController;
use App\Shared\Infrastructure\Http\Controllers\HomeController;
use App\Usuario\Infrastructure\Http\Controllers\UsuarioController;

$app->get('/api/libros', [LibroController::class, 'apiSearch']);

$app->post('/libros', [LibroController::class, 'store']);
$app->get('/libros/create', [LibroController::class, 'create']);
$app->get('/libros/{id}/edit', [LibroController::class, 'edit']);
$app->get('/libros/{id}/delete', [LibroController::class, 'delete']);
$app->get('/libros/{id}', [LibroController::class, 'show']);
$app->get('/libros', [HomeController::class, 'index']);

$app->get('/usuarios/login', [UsuarioController::class, 'login']);
$app->post('/usuarios/login', [UsuarioController::class, 'dologin'])->setName('do_login');

$app->get('/', [HomeController::class, 'index']);