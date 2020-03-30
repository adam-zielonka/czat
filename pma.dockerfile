FROM phpmyadmin/phpmyadmin:fpm-alpine

RUN sed 's/php-fpm/php/g' /docker-entrypoint.sh > /pma-entrypoint.sh
RUN chmod +x /pma-entrypoint.sh

ENTRYPOINT ["/pma-entrypoint.sh"]
CMD [ "php", "-S", "0.0.0.0:80" ]
