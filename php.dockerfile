FROM php:7.4-cli
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli

WORKDIR /var/www
CMD [ "php", "-S", "0.0.0.0:80" ]
