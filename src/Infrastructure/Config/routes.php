<?php
use App\Infrastructure\Http\Controllers\LibroController;
use App\Infrastructure\Http\Controllers\HomeController;

$app->post('/libros', [LibroController::class, 'store']);
$app->get('/libros/{id}', [LibroController::class, 'show']);
$app->get('/', [HomeController::class, 'index']);