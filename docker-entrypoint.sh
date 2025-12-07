#!/bin/bash
set -e

echo "🚀 SmartStock - Starting on Render.com"
echo "======================================="

# 1. Wait for database to be ready
echo ""
echo "⏳ Waiting for database..."
sleep 5

# 2. Generate APP_KEY if not exists
if [ -z "$APP_KEY" ]; then
    echo "⚠️  APP_KEY not set, generating..."
    php artisan key:generate --force --no-interaction
fi

# 3. Run migrations
echo ""
echo "📦 Running migrations..."
php artisan migrate --force --no-interaction || {
    echo "⚠️  Migrations failed, continuing anyway..."
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
chmod -R 775 storage bootstrap/cache 2>/dev/null || true

# 7. Display info
echo ""
echo "ℹ️  Application Info:"
echo "   - PHP: $(php -v | head -n 1)"
echo "   - Laravel: $(php artisan --version)"
echo "   - Environment: ${APP_ENV:-production}"
echo "   - Port: ${PORT:-8080}"

# 8. Start server
echo ""
echo "🌐 Starting Laravel server..."
echo "======================================="

# Execute CMD from Dockerfile
exec "$@"
