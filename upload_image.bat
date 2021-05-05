@echo off

set DOCKER_USERNAME=lbaw2131
set IMAGE_NAME=lbaw2131

composer install
php artisan clear-compiled
php artisan optimize

docker image rm %DOCKER_USERNAME%/%IMAGE_NAME%
docker build -t %DOCKER_USERNAME%/%IMAGE_NAME% .
docker push %DOCKER_USERNAME%/%IMAGE_NAME%
