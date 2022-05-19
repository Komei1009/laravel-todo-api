#!/bin/bash
sudo find /var/www/app -type f -exec chmod 664 {} \;
sudo find /var/www/app -type d -exec chmod 774 {} \;
sudo chown -R ec2-user:nginx /var/www/app

sudo chmod -R 775 /var/www/app/src/storage
sudo chmod -R 775 /var/www/app/src/bootstrap/cache

# db migrate
cd /var/www/app
php artisan migrate

# composer
# cd /var/www/app
# composer install