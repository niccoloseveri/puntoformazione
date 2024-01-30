#!/bin/sh
set -e

echo "Deployment started ..."
#c
# Enter maintenance mode or return true
# if already is in maintenance mode
(php82 artisan down) || true

# Update codebase
git fetch origin deploy
git reset --hard origin/deploy

# Install composer dependencies
php82 /usr/local/bin/composer.phar install --no-dev --no-interaction --prefer-dist --optimize-autoloader

# Run database migrations
php82 artisan migrate --force

# Clear the old cache
php82 artisan clear-compiled

# Recreate cache
php82 artisan optimize

# Exit maintenance mode
php82 artisan up

echo "Deployment finished!"