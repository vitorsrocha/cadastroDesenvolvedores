FROM php:8.3-fpm

RUN apt-get update && apt-get install -y \
    nginx \
    iputils-ping \
    && docker-php-ext-install pdo pdo_mysql \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

COPY ./nginx/default.conf /etc/nginx/conf.d/default.conf
COPY . /var/www/html/
RUN chown -R www-data:www-data /var/www/html
EXPOSE 81

CMD ["sh", "-c", "php-fpm -D && nginx -g 'daemon off;'"]