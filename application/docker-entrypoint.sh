#!/bin/bash

#echo "installing composer libraries"
#composer install
#echo "installing npm packages"
#npm install

echo "running preconfig..."
php artisan migrate
npm run prod
php artisan key:generate
echo "done!"

echo "serving..."
php artisan serve --host=0.0.0.0 --port=8181