FROM php:8.4-cli

RUN apt-get update && apt-get install -y \
    libcurl4-openssl-dev \
    unzip \
    && rm -rf /var/lib/apt/lists/* \
    && docker-php-ext-install curl \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug \
    && echo "xdebug.mode=coverage" > /usr/local/etc/php/conf.d/xdebug-mode.ini

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

ENV COMPOSER_ROOT_VERSION=dev-master

WORKDIR /app

COPY composer.json composer.lock ./
RUN composer install --no-interaction --prefer-dist --no-scripts

COPY . .

CMD ["composer", "check"]
