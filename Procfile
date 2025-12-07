web: vendor/bin/heroku-php-apache2 public/
release: php artisan migrate --force
worker: php artisan queue:work --timeout=3600 --tries=3
