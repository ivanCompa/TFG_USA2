FROM php:8.2-apache

# Instalar extensiones necesarias
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Activar mod_rewrite
RUN a2enmod rewrite

# Copiar código al contenedor
COPY ./src /var/www/html

# Permisos
RUN chown -R www-data:www-data /var/www/html

# Permitir .htaccess
RUN sed -i 's/AllowOverride None/AllowOverride All/g' /etc/apache2/apache2.conf
