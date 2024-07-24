FROM ubuntu:20.04

ARG PHP_VERSION=8.3

ENV TZ=UTC
ENV DEBIAN_FRONTEND=noninteractive

RUN rm -rf /var/www/*

COPY ./src/ /var/www

WORKDIR /var/www

# Install dependencies
RUN apt-get upgrade && \
    apt-get update && \
    apt-get install -y --no-install-recommends \
        build-essential \
        ca-certificates \
        software-properties-common \
        lsb-release \
        nginx \
        curl \
        vim \
        zip \
        unzip \
        wget ;

RUN add-apt-repository ppa:ondrej/php -y

RUN apt-get install -y --no-install-recommends \
        php${PHP_VERSION} \
        php${PHP_VERSION}-cli \
        php${PHP_VERSION}-fpm \
        php${PHP_VERSION}-bz2 \
        php${PHP_VERSION}-curl \
        php${PHP_VERSION}-mbstring \
        php${PHP_VERSION}-intl \
        php${PHP_VERSION}-sqlite \
        php${PHP_VERSION}-mysql \
        php${PHP_VERSION}-xml \
        php${PHP_VERSION}-bcmath ;

# composer install
RUN curl -sS https://getcomposer.org/installer | \
    php -- --install-dir=/usr/local/bin --2.2 --filename=composer

# configure ngix file
RUN echo "server { \
    listen 80 default_server; \
    server_name _ ; \
    root /var/www/public; \
    index index.php; \
    \
    charset utf-8; \
    \
    location / { \
        try_files \$uri \$uri/ /index.php?\$query_string; \
    } \
    \
    error_page 404 /index.php; \
    \
    access_log /var/log/nginx/access.log; \
    error_log /var/log/nginx/error.log warn; \
    \
    location ~ \.php\$ { \
        fastcgi_pass unix:/var/run/php/php${PHP_VERSION}-fpm.sock; \
        fastcgi_index index.php; \
        fastcgi_param SCRIPT_FILENAME \$realpath_root\$fastcgi_script_name; \
        include fastcgi_params; \
    } \
    \
    location ~ /\.(?!well-known).* { \
        deny all; \
    } \
}" > /etc/nginx/sites-available/default ;

# clear temp files
RUN apt-get -y clean && \
    rm -rf /var/lib/apt/lists/* /var/tmp/*

# Install composer packages
# RUN composer install --no-scripts --no-plugins --no-interaction --no-dev

EXPOSE 80

RUN echo "#!/bin/bash\n\
service php${PHP_VERSION}-fpm start\n\
nginx -g \"daemon off;\"" > /entrypoint.sh

RUN chmod +x /entrypoint.sh

ENTRYPOINT ["/entrypoint.sh"]
