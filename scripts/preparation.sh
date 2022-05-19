#!/bin/bash
find /var/www/app -type f -exec chmod 664 {} \;
find /var/www/app -type d -exec chmod 774 {} \;
chown -R ec2-user:nginx /var/www/app

chmod -R 775 /var/www/app/src/storage
chmod -R 775 /var/www/app/src/bootstrap/cache

# db migrate
 cd /var/www/app/src
 php artisan migrate

# composer
 cd /var/www/app/src
 composer install