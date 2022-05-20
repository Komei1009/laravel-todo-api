#!/bin/bash
# db migrate
# shellcheck disable=SC2164
cd /var/www/app
sudo -u nginx php artisan migrate --force

# composer
sudo -u nginx composer install --no-dev
