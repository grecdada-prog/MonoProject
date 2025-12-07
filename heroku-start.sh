#!/bin/bash

# Script de démarrage pour Railway - SmartStock
# Exécute les migrations, optimisations et démarre le serveur

set -e  # Arrêter si erreur

echo "🚀 SmartStock - Démarrage sur Railway"
echo "======================================"

# 1. Vérifier que APP_KEY existe
if [ -z "$APP_KEY" ]; then
    echo "⚠️  APP_KEY manquante, génération..."
    php artisan key:generate --force
fi

# 2. Migrations de base de données
echo ""
echo "📦 Exécution des migrations..."
php artisan migrate --force --no-interaction

# 3. Optimisations Laravel
echo ""
echo "⚡ Optimisation de l'application..."
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache

# 4. Lien symbolique storage
echo ""
echo "🔗 Configuration du stockage..."
php artisan storage:link || echo "⚠️  Storage link déjà créé"

# 5. Permissions (sécurité)
echo ""
echo "🔒 Configuration des permissions..."
chmod -R 775 storage bootstrap/cache
chmod -R 755 public

# 6. Afficher informations système
echo ""
echo "ℹ️  Informations système:"
echo "   - PHP Version: $(php -v | head -n 1)"
echo "   - Laravel Version: $(php artisan --version)"
echo "   - Environment: ${APP_ENV}"
echo "   - Database: ${DB_CONNECTION}"

# 7. Démarrage du serveur web
echo ""
echo "🌐 Démarrage du serveur web sur port ${PORT:-8080}..."
echo "======================================"

# Utiliser le serveur PHP intégré (adapté pour Railway)
php artisan serve --host=0.0.0.0 --port=${PORT:-8080} --no-reload
