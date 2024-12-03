<?php
namespace Tests\Infrastructure;

use App\Libro\Domain\Libro;
use App\Libro\Domain\ISBN;
use PHPUnit\Framework\TestCase;
use PDO;
use App\Libro\Infrastructure\Persistence\MySQLLibroRepository;

/**
 * Tests para el repositorio de libros en MySQL
 * @todo De momento no podemos porque estamos ejecutando phpunit desde el host y debería ser desde el contenedor para tener acceso a la base de datos
 */
class MySQLLibroRepositoryTest extends TestCase
{
    private PDO $pdo;
    private MySQLLibroRepository $repository;

    /**
     * Configura el test creando la base de datos y las tablas desde el fichero de migración
     *
     * @return void
     */
    protected function setUp(): void 
    {
        $config = [
            'migration_file' => 'mysql/migrations.sql',
            'host' => 'localhost',
            'database' => 'test_db',
            'username' => 'test',
            'password' => 'test',
        ];

        $dsn = "mysql:host={$config['host']};dbname={$config['database']};charset=utf8";
        $this->pdo = new PDO($dsn, $config['username'], $config['password']);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $this->repository = new MySQLLibroRepository($config);

        $this->pdo->exec(file_get_contents($config['migration_file']));
    }

    /**
     * Test para crear, actualizar y buscar un libro
     *
     * @return void
     */
    public function testCreateUpdateAndFindLibro()
    {
        $libro = new Libro(
            'El Quijote', 
            'Miguel de Cervantes', 
            new ISBN('0123456789123'), 
            'En un lugar de la mancha'
        );
        $id = $this->repository->create($libro);

        // Buscamos el libro
        $libroEncontrado = $this->repository->find($id);
        $this->assertEquals('El Quijote', $libroEncontrado->toArray()['titulo']);
        $this->assertEquals('Miguel de Cervantes', $libroEncontrado->toArray()['autor']);
        $this->assertEquals('0123456789123', $libroEncontrado->toArray()['isbn']);
        $this->assertEquals('En un lugar de la mancha', $libroEncontrado->toArray()['descripcion']);

        // Actualizamos el libro
        $libro = new Libro(
            'Don Quijote', 
            'Miguel de Cervantes', 
            new ISBN('1234567890123'), 
            'En un lugar de La Mancha, de cuyo nombre no quiero acordarme',
            $id
        );
        $this->repository->update($libroEncontrado);

        // Buscamos el libro actualizado
        $libroEncontrado = $this->repository->find($id);
        $this->assertEquals('Don Quijote', $libroEncontrado->toArray()['titulo']);
        $this->assertEquals('Miguel de Cervantes', $libroEncontrado->toArray()['autor']);
        $this->assertEquals('1234567890123', $libroEncontrado->toArray()['isbn']);
        $this->assertEquals('En un lugar de La Mancha, de cuyo nombre no quiero acordarme', $libroEncontrado->toArray()['descripcion']);
    }

    /**
     * Test para eliminar un libro
     *
     * @return void
     */
    public function testDeleteLibro()
    {
        $libro = new Libro(
            'El Quijote', 
            'Miguel de Cervantes', 
            new ISBN('0123456789123'), 
            'En un lugar de la mancha'
        );
        $id = $this->repository->create($libro);

        $this->repository->delete($id);

        $libroBuscado = $this->repository->find($id);
        $this->assertNull($libroBuscado);
    }
}