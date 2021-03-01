FROM php:8-apache

# WORKDIR /var/www/html (FROM php:8-apache)
# EXPOSE 80 (FROM php:8-apache)

# Copy static HTML pages (when building a new image)
COPY html/ /var/www/html
