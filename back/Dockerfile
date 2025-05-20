FROM php:8.2-cli
COPY . /usr/src/agendaBella
WORKDIR /usr/src/agendaBella
EXPOSE 80

RUN  apt-get update && \
        apt-get install zip -y  && \
        apt-get clean
        # && \docker-php-ext-install zip -y

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php \
    && php -r "unlink('composer-setup.php');" \
    && mv composer.phar /usr/local/bin/composer

RUN touch index.php
RUN echo "<?php phpinfo(); ?>" > index.php
#CMD ["php", "-S", "0.0.0.0:80"]
CMD [ "php", "artisan", "serve", "--host=0.0.0.0", "--port=80" ]
