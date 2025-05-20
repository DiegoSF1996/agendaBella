FROM php:8.2-fpm
COPY . /usr/src/agendaBella
WORKDIR /usr/src/agendaBella
EXPOSE 80

RUN apt-get update && apt-get install -y \
    libzip-dev \
    unzip \
    && docker-php-ext-install zip pdo_mysql mysqli


RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php \
    && php -r "unlink('composer-setup.php');" \
    && mv composer.phar /usr/local/bin/composer

#CMD ["php", "-S", "0.0.0.0:80"]
CMD [ "php", "artisan", "serve", "--host=0.0.0.0", "--port=80" ]
