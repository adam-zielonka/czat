FROM php:8.5-cli
RUN docker-php-ext-install mysqli
WORKDIR /var/www
CMD ["php", "-S", "0.0.0.0:80", "-t", "/var/www"]
