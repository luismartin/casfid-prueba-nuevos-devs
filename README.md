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


* [Web](http://localhost:8080){:target="_blank"}
* [phpMyAdmin](http://localhost:8081){:target="_blank"} (test:test)

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