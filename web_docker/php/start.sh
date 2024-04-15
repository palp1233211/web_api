#!/bin/bash

# Start php-fpm
php-fpm &

# Execute swoole.php
php /mnt/www/public/swoole_server.php &

# Keep the container running
tail -f /dev/null
