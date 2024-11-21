<?php
namespace App\Infrastructure\Services;

use App\Domain\Libro\LibroFinder;
use App\Domain\Libro\Libro;
use App\Domain\Shared\ISBN;

class GoogleApiLibroFinder implements LibroFinder
{
    public function __construct(private array $config)
    {}

    public function search(string $search): array
    {
        $base_url = $this->config['base_url'];
        $url = $base_url . urlencode($search);
        $response = file_get_contents($url);
        $data = json_decode($response, true);
        /*DEBUG(LMS)*/// echo "<pre>" . print_r($data['items'], true) . "</pre>"; exit;
        $libros = [];
        foreach ($data['items'] as $item) {
            /*DEBUG(LMS)*/// echo "<pre>" . print_r($item['volumeInfo']['description'], true) . "</pre>";
            $libros[] = new Libro(
                $item['volumeInfo']['title'],
                $item['volumeInfo']['authors'][0],
                new ISBN($this->getISBN_13($item)),
                $item['volumeInfo']['description'] ?? 'Sin descripción'
            );
        }
        return $libros;
    }

    private function getISBN_13(array $item): string
    {
        $isbn = '';
        foreach ($item['volumeInfo']['industryIdentifiers'] as $identifier) {
            if ($identifier['type'] === 'ISBN_13') {
                $isbn = $identifier['identifier'];
            }
        }
        return $isbn;
    }
}