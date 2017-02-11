FROM php:7-apache

RUN apt-get update && apt-get install -y \
        libmcrypt-dev \
    && docker-php-ext-install -j$(nproc) mcrypt

RUN a2enmod ssl
RUN service apache2 restart

RUN mkdir /etc/apache2/ssl

RUN openssl genrsa -out /etc/apache2/ssl/ca.key 2048
RUN openssl req -nodes -new -key /etc/apache2/ssl/ca.key -out /etc/apache2/ssl/ca.csr -subj '/CN=www.fried-air.com/O=Fried Air LTD./C=US'
RUN openssl x509 -req -days 365 -in /etc/apache2/ssl/ca.csr -signkey /etc/apache2/ssl/ca.key -out /etc/apache2/ssl/ca.crt

COPY ./000-default.conf /etc/apache2/sites-enabled/000-default.conf

RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

RUN service apache2 restart
# RUN /etc/init.d/apache2 restart

COPY . /var/www/html/

EXPOSE 443
EXPOSE 80

#docker build -t my-php-app .;docker run -d -p 80:80 -p 443:443 -v /Users/koen/Bloqhouse/idintt/hackathon-module/idintt-php-module/demo-scripts:/var/www/html/demo-scripts --name my-running-app my-php-app
#docker kill $(docker ps -qa);docker rm -v $(docker ps -qa);docker build -t my-php-app .;docker run -d -p 80:80 -p 443:443 -v /Users/koen/Bloqhouse/idintt/hackathon-module/idintt-php-module/demo-scripts:/var/www/html/demo-scripts --name my-running-app my-php-app
