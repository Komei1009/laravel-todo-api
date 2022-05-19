#!/bin/bash
find /home/ec2-user/laravel-todo-api -type f -exec chmod 664 {} \;
find /home/ec2-user/laravel-todo-api -type d -exec chmod 774 {} \;
chown -R ec2-user:nginx /home/ec2-user/laravel-todo-api

chmod -R 775 /home/ec2-user/laravel-todo-api/src/storage
chmod -R 775 /home/ec2-user/laravel-todo-api/src/bootstrap/cache

# db migrate
cd /home/ec2-user/laravel-todo-api/src/app
php artisan migrate

# composer
 cd /home/ec2-user/laravel-todo-api/src/app
 composer install