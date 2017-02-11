Run docker container

docker build -t my-php-app .;
docker run -d -p 80:80 -p 443:443 --name my-running-app my-php-app

Go to
localhost/app/index.php
