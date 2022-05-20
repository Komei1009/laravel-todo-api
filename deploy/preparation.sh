#!/bin/bash
find  /var/www/app -type f -exec chmod 664 {} \;
find /var/www/app -type d -exec chmod 774 {} \;
chown -R ec2-user:nginx /var/www/app

# db migrate
 # shellcheck disable=SC2164
 cd /var/www/app
 sudo -u nginx php artisan migrate

# composer
 # shellcheck disable=SC2164
 sudo -u nginx composer install
