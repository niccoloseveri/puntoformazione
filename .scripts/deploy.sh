#!/bin/bash
set -e

echo "Deployment started ..."
#c
# Enter maintenance mode or return true
# if already is in maintenance mode
(php artisan down --message 'The app is being (quickly!) updated. Please try again in a minute.') || true

# Pull the latest version of the app
git pull origin production

# Install composer dependencies
/usr/bin/php82 /usr/local/bin/composer.phar install

# Run database migrations
php artisan migrate --force

# Clear the old cache
php artisan clear-compiled

# Recreate cache
php artisan optimize

# Compile npm assets
#npm run prod



# Exit maintenance mode
php artisan up

echo "Deployment finished!"
