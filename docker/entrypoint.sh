#!/bin/bash

echo "ENV is set to: $ENV"  # Exibe o valor de APP_ENV

# if [ "$ENV" = "local" ]; then
#     cp /docker/nginx/default.local /etc/nginx/sites-available/default
# else
#     cp /docker/nginx/default.production /etc/nginx/sites-available/default
# fi

cp /docker/nginx/default.local /etc/nginx/sites-available/default

rm -rf /docker/mysql
rm -rf /docker/Dockerfile

service php8.4-fpm start

exec "$@"
