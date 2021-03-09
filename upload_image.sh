#!/bin/bash

read -p "Press [Enter] key to start backup..."

# Stop execution if a step fails
set -e

DOCKER_USERNAME=lbaw2131 
IMAGE_NAME=lbaw2131-piu

# necessário dar: `docker login` na máquina
docker build -t $DOCKER_USERNAME/$IMAGE_NAME .
docker push $DOCKER_USERNAME/$IMAGE_NAME

# para dar run

# docker run -it -p 8000:80 -v $PWD/html:/var/www/html <DOCKER_USERNAME>/<IMAGE NAME>
# https://stackoverflow.com/questions/41485217/mount-current-directory-as-a-volume-in-docker-on-windows-10

# localhost:8000 no browser