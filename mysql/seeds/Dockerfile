FROM php:8.2-cli

# Instalar la extensión pdo_mysql y el cliente de MySQL
RUN apt-get update && apt-get install -y \
    default-mysql-client \
    && docker-php-ext-install pdo pdo_mysql