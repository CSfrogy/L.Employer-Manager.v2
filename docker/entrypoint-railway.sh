#!/bin/bash
set -e

# Change to the application directory
cd /var/www/html

echo "Starting Railway deployment..."

# Install composer dependencies if vendor directory doesn't exist or is empty
if [ ! -d "vendor" ] || [ -z "$(ls -A vendor 2>/dev/null)" ]; then
    echo "Installing composer dependencies..."
    composer install --optimize-autoloader --no-dev
fi

# Generate application key if it doesn't exist
if [ ! -f ".env" ] || ! grep -q "APP_KEY=base64:" .env 2>/dev/null; then
    echo "Generating application key..."
    php artisan key:generate --force
fi

# Wait for database to be ready (if DB_HOST is set)
if [ ! -z "$DB_HOST" ]; then
    echo "Waiting for database to be ready..."
    until nc -z $DB_HOST 3306; do
        echo "Waiting for database..."
        sleep 1
    done
    echo "Database is ready!"
fi

# Clear and cache configuration files in production
if [ "$APP_ENV" = "production" ]; then
    echo "Caching configuration files..."
    php artisan config:cache
    php artisan route:cache
    php artisan view:cache
fi

# Run migrations in production if RUN_MIGRATIONS is true
if [ "$APP_ENV" = "production" ] && [ "$RUN_MIGRATIONS" = "true" ]; then
    echo "Running database migrations..."
    php artisan migrate --force
fi

# Run seeders if SEED is true
if [ "$SEED" = "true" ]; then
    echo "Running database seeders..."
    php artisan db:seed --force
fi

# Set proper permissions for Railway
chown -R www-data:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache

echo "Application ready!"

# Execute the main command
exec "$@"
