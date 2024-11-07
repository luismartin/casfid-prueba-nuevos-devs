CREATE TABLE IF NOT EXISTS `usuarios` (
    `id` int NOT NULL AUTO_INCREMENT,
    `username` varchar(50) NOT NULL,
    `password` varchar(255) NOT NULL,
    `email` varchar(100) NOT NULL,
    PRIMARY KEY (`id`)
);

CREATE TABLE IF NOT EXISTS `libros` (
    `id` int NOT NULL AUTO_INCREMENT,
    `titulo` varchar(255) NOT NULL,
    `autor` varchar(255) NOT NULL,
    `isbn` varchar(13) NOT NULL,
    `descripcion` varchar(500) NOT NULL,
    PRIMARY KEY (`id`)
);