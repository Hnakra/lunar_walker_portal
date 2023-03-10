FROM php:8.1-cli

ADD supervisord.conf /etc/

RUN docker-php-ext-install pdo_mysql \
    && docker-php-ext-install bcmath \
    && apt-get update \
    && apt-get install -y --no-install-recommends supervisor

CMD ["supervisord", "-c", "/etc/supervisord.conf"]
