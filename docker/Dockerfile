FROM debian:bookworm-slim

ARG PHP_VERSION=8.4

ENV TZ=America/Sao_Paulo \
    DEBIAN_FRONTEND=noninteractive \
    ENV=production \
    COMPOSER_ALLOW_SUPERUSER=1

# Adiciona repositório SURY para PHP 8.4
RUN apt-get update && apt-get install -y --no-install-recommends \
    ca-certificates \
    apt-transport-https \
    lsb-release \
    curl && \
    echo "deb https://packages.sury.org/php/ $(lsb_release -cs) main" | tee /etc/apt/sources.list.d/sury-php.list && \
    curl -fsSL https://packages.sury.org/php/apt.gpg | tee /etc/apt/trusted.gpg.d/sury-php.gpg > /dev/null && \
    apt-get update

# Instala PHP e extensões necessárias
RUN apt-get install -y --no-install-recommends \
    nginx \
    unzip \
    git \
    zip \
    php${PHP_VERSION}-fpm \
    php${PHP_VERSION}-cli \
    php${PHP_VERSION}-curl \
    php${PHP_VERSION}-mbstring \
    php${PHP_VERSION}-intl \
    php${PHP_VERSION}-sqlite \
    php${PHP_VERSION}-mysql \
    php${PHP_VERSION}-xml \
    php${PHP_VERSION}-gd \
    php${PHP_VERSION}-bcmath \
    php${PHP_VERSION}-memcached \
    php${PHP_VERSION}-zip && \
    rm -rf /var/lib/apt/lists/* /var/tmp/*

# Define o diretório correto para a aplicação
WORKDIR /var/www

COPY ./src/ /var/www
COPY ./docker /docker

# composer install
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --2.7 --filename=composer

# Altera para usuário www-data e instala composer
RUN composer install --no-ansi --no-dev --no-interaction --no-plugins --no-progress --optimize-autoloader

# Remove pacotes temporários
RUN apt-get -y clean && \
    rm -rf /var/lib/apt/lists/* /var/tmp/*

# Porta do container
EXPOSE 80
EXPOSE 443

# Entrypoint script
COPY ./docker/entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

ENTRYPOINT ["/entrypoint.sh"]

CMD ["nginx", "-g", "daemon off;"]
