#!/bin/bash
find /var/www/app -type f -exec chmod 664 {} \;
find /var/www/app -type d -exec chmod 774 {} \;
chown -R ec2-user:nginx /var/www/app
#
##chmod -R 775 /var/www/app/storage
##chmod -R 775 /var/www/app/bootstrap/cache
#
## db migrate
# # shellcheck disable=SC2164
 cd /var/www/app
 sudo -u nginx php artisan migrate --force
#
## composer
# # shellcheck disable=SC2164
 sudo -u nginx composer install --force
