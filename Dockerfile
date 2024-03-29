# @todo: argument/env var?
FROM wordpress:5.5

RUN apt-get update && \
  apt-get install -y libxslt1-dev default-mysql-client && \
  docker-php-ext-install xsl

RUN curl -O https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar \
  && chmod +x wp-cli.phar \
  && mv wp-cli.phar /usr/local/bin/wp
RUN wp --info --allow-root

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN pecl install xdebug
RUN docker-php-ext-enable xdebug

COPY ./.docker/xdebug.ini /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
