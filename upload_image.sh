#!/bin/bash

read -p "Press [Enter] key to start backup..."

# Stop execution if a step fails
set -e

DOCKER_USERNAME=lbaw2131        # Replace by your docker hub username
IMAGE_NAME=lbaw2131             # Replace with your group's image name

# Ensure that dependencies are available
composer install
php artisan clear-compiled
php artisan optimize

docker build -t $DOCKER_USERNAME/$IMAGE_NAME .
docker push $DOCKER_USERNAME/$IMAGE_NAME

# para dar run

# docker run -it -p 8000:80 -v $PWD/html:/var/www/html <DOCKER_USERNAME>/<IMAGE NAME>
# docker run -it -p 8000:80 -e DB_DATABASE="lbaw2131" -e DB_USERNAME="lbaw2131" -e DB_PASSWORD=YM436030  lbaw2131/lbaw2131

# https://stackoverflow.com/questions/41485217/mount-current-directory-as-a-volume-in-docker-on-windows-10

# localhost:8000 no browser
