#!/usr/bin/env bash

set -e

docker-compose down
echo "Starting services"
docker-compose up -d

docker-compose exec php cp /var/www/html/.env.example /var/www/html/.env

 [ -f "./backend/.env" ] || $(echo Please make an .env file --env=docker; exit 1)
export $(cat ./backend/.env | grep -v ^# | xargs);

until docker-compose exec mysql mysql -h mysql -u $DB_USERNAME -p$DB_PASSWORD -D $DB_DATABASE --silent -e "show databases;"
do
  echo "Waiting for database connection..."
  sleep 5
done

echo "Installing dependencies"
docker-compose run --rm composer install
docker-compose run --rm php chgrp -R www-data storage
docker-compose run --rm php chmod -R ug+rwx storage

echo "Migrating database"
docker-compose run --rm php php artisan migrate
echo "Database migrated"

echo "PHP Unit testing..."
docker-compose run --rm php vendor/bin/phpunit

echo "Go to $APP_URL for API & $FRONTEND_URL for Frontend"
