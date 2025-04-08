FROM php:8.4-fpm-alpine

# Install Alpine build tools and PHP dependencies
RUN apk add --no-cache \
    bash \
    git \
    curl \
    unzip \
    zip \
    oniguruma-dev \
    libxml2-dev \
    libzip-dev \
    postgresql-dev \
    freetype-dev \
    libjpeg-turbo-dev \
    libpng-dev \
    libwebp-dev \
    libc-dev \
    make \
    autoconf \
    gcc \
    g++ \
    && pecl install redis \
    && docker-php-ext-enable redis \
    && docker-php-ext-install -j$(nproc) \
        pdo \
        pdo_pgsql \
        mbstring \
        zip \
        gd \
        xml

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www
COPY . .

# Set permissions (optional)
RUN chown -R www-data:www-data /var/www \
    && chmod -R 755 /var/www

CMD ["php-fpm"]