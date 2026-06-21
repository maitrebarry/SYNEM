#!/bin/bash
# Démarre le serveur de développement avec les limites PHP upload correctes.
# PHP_INI_SCAN_DIR est hérité par le processus enfant (php -S) spawné par artisan serve.
PHP_INI_SCAN_DIR=":/opt/lampp/htdocs/SYNEM/php-ini-overrides" php artisan serve "$@"
