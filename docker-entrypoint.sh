#!/bin/bash
set -e

echo "🚀 SmartStock - Starting on Render.com (Apache)"
echo "======================================="

# Set PORT default if not provided
export PORT=${PORT:-8080}

# 1. Wait for database
echo ""
echo "⏳ Waiting for database..."
sleep 3

# 2. Generate APP_KEY if not exists
if [ -z "$APP_KEY" ]; then
    echo "⚠️  APP_KEY not set, generating..."
    php artisan key:generate --force --no-interaction
fi

# 3. Run migrations
echo ""
echo "📦 Running migrations..."
php artisan migrate --force --no-interaction || {
    echo "⚠️  Migrations failed, continuing..."
}

# 4. Laravel optimizations
echo ""
echo "⚡ Optimizing Laravel..."
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache

# 5. Storage link
echo ""
echo "🔗 Creating storage link..."
php artisan storage:link || echo "⚠️  Storage link already exists"

# 6. Set permissions
echo ""
echo "🔒 Setting permissions..."
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache 2>/dev/null || true
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache 2>/dev/null || true

# 7. Display info
echo ""
echo "ℹ️  Application Info:"
echo "   - PHP: $(php -v | head -n 1)"
echo "   - Laravel: $(php artisan --version)"
echo "   - Environment: ${APP_ENV:-production}"
echo "   - Port: ${PORT}"
echo "   - Server: Apache"

# 8. Start Apache
echo ""
echo "🌐 Starting Apache server on port ${PORT}..."
echo "======================================="

# Execute Apache
exec "$@"
