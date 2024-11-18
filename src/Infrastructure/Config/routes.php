<?php
use App\Infrastructure\Http\Controllers\LibroController;
use App\Infrastructure\Http\Controllers\HomeController;

$app->post('/libros', [LibroController::class, 'store']);
$app->get('/libros/create', [LibroController::class, 'create']);
$app->get('/libros/{id}/editar', [LibroController::class, 'edit']);
$app->get('/libros/{id}', [LibroController::class, 'show']);
$app->get('/libros', [HomeController::class, 'index']);
$app->get('/', [HomeController::class, 'index']);