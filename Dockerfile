# Usa una imagen oficial de PHP con Apache
FROM php:8.1-apache

# Copia todo el contenido del proyecto al servidor Apache
COPY . /var/www/html/

# Abre el puerto 80 para el tráfico web
EXPOSE 80
