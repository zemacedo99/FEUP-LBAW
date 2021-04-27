@echo off 

set DOCKER_USERNAME=lbaw2131
set IMAGE_NAME=lbaw2131

docker image rm %DOCKER_USERNAME%/%IMAGE_NAME%
docker build -t %DOCKER_USERNAME%/%IMAGE_NAME% .
docker push %DOCKER_USERNAME%/%IMAGE_NAME%

