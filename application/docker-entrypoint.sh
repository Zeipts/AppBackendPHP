#!/bin/bash

echo "running setup..."
php artisan migrate
npm run prod
