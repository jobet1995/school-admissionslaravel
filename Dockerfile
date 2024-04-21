FROM php:8.2-cli
FROM mysql:8.0

ENV MYSQL_ROOT_PASSWORD=root

ENV MYSQL_DATABASE=mydatabase

COPY init.sql /docker-entrypoint-initdb.d/

WORKDIR /var/www/html

# Copy application files
COPY . /var/www/html

# Expose port
EXPOSE 8000

# Start Laravel application
CMD php artisan serve --host=0.0.0.0 --port=8000