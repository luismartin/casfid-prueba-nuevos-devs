<?php
namespace App\Libro\Infrastructure\Services;

use App\Libro\Domain\LibroFinder;
use App\Libro\Domain\Libro;
use App\Libro\Domain\LibroNotFoundException;
use App\Libro\Domain\ISBN;

/**
 * Implementación del servicio de dominio LibroFinder que utiliza la API de Google Books para buscar libros
 */
class GoogleApiLibroFinder implements LibroFinder
{
    public function __construct(private array $config) {}

    public function search(string $search): array
    {
        $base_url = $this->config['base_url'];
        $url = $base_url . urlencode($search);
        $response = file_get_contents($url);
        if (! $response) {
            throw new \Exception('Error al obtener los datos');
        }
        $data = json_decode($response, true);
        if (! $data) {
            throw new \Exception('Error al decodificar los datos');
        }
        $libros = [];
        foreach ($data['items'] as $item) {
            $libros[] = new Libro(
                $item['volumeInfo']['title'],
                $item['volumeInfo']['authors'][0] ?? 'Sin autor',
                new ISBN($this->getISBN_13($item['volumeInfo'])),
                $item['volumeInfo']['description'] ?? 'Sin descripción'
            );
        }
        return $libros;
    }

    /**
     * Extrae el ISBN_13 de un array de datos de un libro
     *
     * @param array $item
     * @return string
     */
    private function getISBN_13(array $info): string
    {
        $industryIdentifiers = $info['industryIdentifiers'] ?? [];
        foreach ($industryIdentifiers as $identifier) {
            if ($identifier['type'] === 'ISBN_13') {
                return $identifier['identifier'];
            }
        }
        return '0000000000000';
    }
}