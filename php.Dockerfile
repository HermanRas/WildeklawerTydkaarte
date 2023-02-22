FROM php:7.4.3-apache
RUN docker-php-ext-install mysqli pdo pdo_mysql
RUN apt-get update && apt-get install wget -y


#setup Env
RUN a2enmod ssl && a2enmod rewrite
RUN mkdir -p /etc/apache2/ssl
RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"

#Copy SSL Certs
COPY ./test/*.pem /etc/apache2/ssl/
COPY ./test/*.key /etc/apache2/ssl/
COPY ./test/000-default.conf /etc/apache2/sites-available/000-default.conf

#Open HTTP & HTTPS
EXPOSE 80
EXPOSE 443