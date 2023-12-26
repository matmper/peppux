FROM php:8.3.0beta3-fpm

ENV COMPOSER_ALLOW_SUPERUSER=${COMPOSER_ALLOW_SUPERUSER:-0}

RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        curl \
        libonig-dev \
        libxml2-dev \
        libzip-dev \
        libjpeg62-turbo-dev \
        libfreetype6-dev \
        unzip \
        vim \
        && docker-php-ext-install pdo_mysql \
        && docker-php-ext-install mysqli \
        && docker-php-ext-install mbstring \
        && docker-php-ext-install exif \
        && docker-php-ext-install pcntl \
        && docker-php-ext-install bcmath \
        && docker-php-ext-install zip \
        && docker-php-ext-configure gd --with-freetype --with-jpeg \
        && docker-php-ext-install gd
        #&& pecl install xdebug-3.1.1 \
        #&& docker-php-ext-enable xdebug

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Clear workit
RUN rm -rf /var/www/html/*

# Set workdir
WORKDIR /var/www/html

# Copy local files to workdir
COPY . .

# Install composer
# RUN composer install --no-dev --no-interaction

# Expode public port
EXPOSE 9000

CMD ["php-fpm"]
