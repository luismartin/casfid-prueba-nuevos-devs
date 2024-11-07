FROM php:8.2-apache

# Actualizar los paquetes e instalar extensiones de PHP
RUN apt update \
    && docker-php-ext-install mysqli \
    && docker-php-ext-install pdo_mysql

# Habilitar el módulo mod_rewrite de Apache
RUN a2enmod rewrite

# Establecer el DocumentRoot a /var/www/html/public
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf

# Configurar el directorio public
RUN echo '<Directory /var/www/html/public>\n\
    Options Indexes FollowSymLinks\n\
    AllowOverride All\n\
    Require all granted\n\
</Directory>' >> /etc/apache2/apache2.conf

# Establecer el ServerName para evitar advertencias
RUN echo 'ServerName localhost' >> /etc/apache2/apache2.conf

# Reiniciar Apache para aplicar los cambios
RUN service apache2 restart