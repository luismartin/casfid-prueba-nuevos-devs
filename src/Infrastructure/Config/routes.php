<?php
use App\Infrastructure\Http\Controllers\LibroController;

$app->post('/libros', [LibroController::class, 'store']);
$app->get('/libros/{id}', [LibroController::class, 'show']);