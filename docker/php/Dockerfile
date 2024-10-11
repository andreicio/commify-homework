FROM php:fpm-alpine

# Packages
RUN apk add --no-cache curl git build-base zlib-dev oniguruma-dev autoconf icu-dev bash linux-headers

# Postgres
RUN apk add --no-cache libpq-dev && docker-php-ext-install pdo_pgsql

# Intl
RUN docker-php-ext-configure intl && docker-php-ext-install intl

# XDebug
RUN pecl install xdebug && docker-php-ext-enable xdebug

# Non root user
ARG PUID=1000
ARG PGID=1000
RUN apk --no-cache add shadow && \
    groupmod -o -g ${PGID} www-data && \
    usermod -o -u ${PUID} -g www-data www-data

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

# Set user
USER www-data

# Run php-fpm
CMD php-fpm

WORKDIR /var/www

# Expose port
EXPOSE 9000