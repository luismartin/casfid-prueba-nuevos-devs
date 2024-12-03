# Servicio básico de libros

Hemos usado servicios de Docker con Apache, PHP y MySQL, como tecnologías principales.
Para el enrutamiento usamos Slim, y para las plantillas HTML usamos Twig. 
A aplicación está diseñada modelando el dominio, y usa arquitectura hexagonal.
Para la compilación de los assets del frontend usamos Webpack.


### 1. Requisitos de software en el host

* [Git](https://git-scm.com/)
* [Docker](https://www.docker.com/)
* [Docker Compose](https://docs.docker.com/compose/)
* [Composer](https://getcomposer.com) para instalar dependencias de backend
* [Node.js](https://nodejs.com) Usamos npm para instalar dependencias de frontend


### 2. Cómo ejecutar el proyecto

* Clonar repo
* Entrar en el directorio del repo
* Ejecutar los siguientes comandos:
  * `docker-compose up -d`  
  * `composer install`
  * `npm install`
* O bien, ejecutar:
  * `make up`, el cual incluye las tres cosas
    * (el comando Make puede requerir instalación previa).


* [Web](http://localhost:8080)
* [phpMyAdmin](http://localhost:8081)

### 3. Otros comandos

* Ejecutar tests
  * `./vendor/bin/phpunit` (temporal)
    * <span style="color:red">**ToDo**: Deberíamos ejecutarlos desde el servicio apache de docker-compose para poder acceder a mysql en los tests de infraestructura</span>
* Para limpiar la caché de Twig:
  * `composer run clear-cache`
* Compilar assets del frontend:
  * Para desarrollo:
    * `npm run dev`
  * Para producción:
    * `npm run build`
  * Ejecutar un watcher para compilar tras guardar (no lo he probado)
    * `npm run watch`

### 4. API de enrutamiento

* **GET /**
  * Página principa, la cual muestra una tabla de libros guardados en nuestra base de datos
* **GET /libros**
  * Idem que la anterior
* **GET /api/libros**
  * Obtiene libros por búsqueda en API externa
* **GET /libros/create**
  * Muestra formulario para crear un nuevo libro 
* **POST /libros**
  * Almacena un libro (inserta o actualiza)
* **GET /libros/{id}/edit**
  * Muestra formulario para editar el libro solicitado
* **GET /libros/{id}/delete**
  * Elimina el libro solicitado
* **GET /libros/{id}**
  * Muestra la página del libro solicitado

### 5. Generar la documentación con PhpDocumentor

Ejecuta:
`docker-compose run --rm phpdoc`

Acceder a la documentación:
<a href="https://luismartin.github.io/prueba-nuevos-devs/" target="_blank">documentación</a>

### 6. Explicación de la estructura del proyecto

Directorios:
* assets
  * Contiene los ficheros fuente para Javascript y CSS. Estos son compilados por Webpack en un bundle de public/dist.
    * Al compilar para dev, no minifica ni quita posibles console.log, entre otras cosas.
* cache
  * De momento se está usando solo para la caché de las plantillas de Twig
* config 
  * Guarda las variables de configuración de la aplicación
* docs
  * documentación de la aplicación PHP autogenerada por PhpDocumentor
* logs
  * Lo estoy usando para meter logs en texto plano
* mysql
  * El volumen para la base de datos
  * Contiene también el fichero de inicialización de la base de datos desde Docker
  * Contiene un seeder que no he conseguido que funcione
* mode_modules
  * Dependencias del frontend
* public
  * Directorio público accesible por Apache.
* src
  * Directorio fuente de la aplicación. Explicado en detalle en siguiente sección.
* tests
  * Suite de tests con PhpUnit
* vendor
  * Dependencias del backend
  
Ficheros en la raíz:
* .env
  * Proporciona las variables de entorno de la aplicación
    * No se trackea con Git para usar el apropiado dependiendo de donde se despliegue
* .env.ejemplo
  * El fuente que trackeamos para modificar a conveniencia y renombrar por .env allá donde lo despleguemos
* .gitignore
  * Ficheros a ignorar por Git
* .htaccess
  * Reglas para reescritura de las URLs
* .travis.yml
  * Automatizador de tareas para CI
  * No lo he podido hacer funcionar por un error extraño en Travis
* clear_cache.php
  * Script PHP para limpieza de la caché de Twig
* composer.json y composer.lock
  * Define dependencias de PHP y comando para ejecutar el script anterior
* docker-compose.yml y Dockerfile
  * Configuración de los servicios de Docker
  * El Dockerfile es usado por el servicio "apache"
* Makefile
  * Define una secuencia de comandos a ejecutar con el fin de poner en marcha el proyecto, para ahorrarnos meterlos uno a uno
* package.json y package-lock.json
  * Dependencias del frontend y define comandos para compilar los assets
* phpdoc.dist.xml
  * Configuración de PhpDocumentor para la generación de la documentación de las clases y métodos de PHP
* phpunit.xml
  * Configuración de PhpUnit para lanzar los tests
* README.md
  * myself
* webpack.config.mjs
  * Configuración para compilar los assets con Webpack (este es importado desde npm <-- package.json)
  * Usamos extensión mjs porque me resulta más cómoda la notación ES6 que la CommonJS
  
### 7. Explicación de la estructura de ficheros PHP en src

Seguimos el diseño orientado a dominio (DDD). De ahí la estructura de los tres directorios dentro de cada agregado o dominio. Por ejemplo, para Libro:
* Domain
  * En ella tenemos un subdirectorio por agregado, y Shared, para elementos compartidos por agregados
  * Dentro del agregado Libro tenemos
    * La entidad Libro, y servicios, excepciones y repositorios, tosos pertenecientes al dominio.
* Application
  * Contiene un subdirectorio por agregado, y en cada uno, sus Servicios de Aplicaciones (Casos de Uso), y DTOs
    * Las DTOs son objetos simples sin lógica, para evitar que el controlador o cualquier infraestructura maneje directamente los objetos entidad. 
* Infrastructure (en detalle en sección siguiente).
  * Http/Controllers
    * Se encargan del I/O (peticiones/respuestas) siguiendo el estándar [PSR-7](https://www.php-fig.org/psr/psr-7/)
    * En este caso, contiene controladores del framework para peticiones relativas a Libro. Slim en este caso, los cuales, dependiendo del caso, pasa los datos a Twig (HTML) o los envía como JSON.
  * Persistence
    * Contiene el repositorio concreto de MySQL y la implementación del servicio de búsqueda de libros en API externa
  * Services
    * Contiene la implementación del servicio de obtención externa de libros, usando la API de Google Books.

### 8. Recursos compartidos (Shared)

También hay un directorio Shared, para recursos compartidos entre agregados, y en el cual también dividimos por dominio, aplicación e infraestructura:

* Domain
  * Contiene la interfaz de Entity, la cual usarán las de los dominios para cumplir con su API
  * Userid (por implementar)
* Infrastructure
  * Http/Controllers
    * Incluye un controlador principal, el cual heredan el resto, desde donde se define un método formatResponse que permite diferenciar respuestas HTML y respuestas JSON.
    * También contiene el controlador de la Home
  * Middleware
    * No he conseguido que funcione de momento :(
    * Lo he creado para que el contenedor contenga qué formato de respuesta (HTML/JSON) se debería usar dependiendo de si recibimos un query parameter `format=json`. 
    * Como no lo he conseguido hacer funcionar, esta comprobación se hace en el mismo método formatParameter
  * templates
    * Contiene las plantillas de Twig