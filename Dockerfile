FROM php:7

RUN apt-get update -y && apt-get install -y openssl zip unzip git curl gnupg libpng-dev build-essential
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN curl -sL https://deb.nodesource.com/setup_10.x  | bash -
RUN apt-get -y install nodejs && docker-php-ext-install pdo mbstring
WORKDIR /app
COPY . /app
WORKDIR /app/application

RUN composer install && npm install

#Generate new key
RUN cp .env.base .env
RUN chmod a+x docker-entrypoint.sh
ENTRYPOINT ["./docker-entrypoint.sh"]

EXPOSE 8181