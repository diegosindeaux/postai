#!/bin/bash

until nc -z -v -w30 mysql 3306
 do
   echo "Aguardando o MySQL iniciar..."
      sleep 5
done

# Copiar .env.example para .env se .env não existir
if [ ! -f .env ]; then
    cp .env.example .env
    echo "Arquivo .env criado a partir do .env.example"
fi

# Gerar chave da aplicação se não existir
if [ -z "$(grep '^APP_KEY=' .env | cut -d '=' -f2)" ] || [ "$(grep '^APP_KEY=' .env | cut -d '=' -f2)" = "" ]; then
    php artisan key:generate
    echo "Chave da aplicação gerada"
fi

php artisan config:clear
php artisan cache:clear
php artisan config:cache

php artisan create:database-if-not-exists

php artisan migrate

exec php-fpm -F
