#
# Build/Start/Stop using docker-compose:
#
# For changes to this file or docker-compose.yml
#   docker-compose build
#
# For running containers and see live logs of services
#   docker-compose up
#
# For running containers as deamon and take console back
#   docker-compose up -d
#
# For stoping containers
#   docker-compose down
#
#
# You can install dependencies via the container:
#
#   docker-compose run {{volume_name}} composer install
#
FROM php:8.2-apache

RUN apt-get update \
 && apt-get install -y git zlib1g-dev mariadb-client libzip-dev \
 nodejs \
 npm 

RUN docker-php-ext-install zip mysqli pdo_mysql \
 && pecl install xdebug \
 && docker-php-ext-enable xdebug \
 && echo 'xdebug.client_enable=on' >> /usr/local/etc/php/conf.d/xdebug.ini \
 && echo 'xdebug.client_host=host.docker.internal' >> /usr/local/etc/php/conf.d/xdebug.ini \
 && echo 'xdebug.client_port=9003' >>  /usr/local/etc/php/conf.d/xdebug.ini \
 && a2enmod rewrite \
 && sed -i 's!/var/www/html!/var/www/public!g' /etc/apache2/sites-available/000-default.conf \
 && mv /var/www/html /var/www/public \
 && echo 'ServerName localhost' >> /etc/apache2/apache2.conf 


RUN curl -sS https://getcomposer.org/installer \
  | php -- --install-dir=/usr/local/bin --filename=composer


WORKDIR /var/www/public


# Install php dependencies
COPY composer.json composer.json
RUN composer install --prefer-dist --no-scripts --no-dev --no-autoloader && rm -rf /root/.composer
RUN composer dump-autoload --no-scripts --no-dev --optimize


# Install js dependencies
COPY package.json package.json
RUN npm install
