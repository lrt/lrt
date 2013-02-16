php-cli app/console doctrine:schema:drop --force --env=prod
php-cli app/console doctrine:schema:create --env=prod
php-cli app/console doctrine:fixtures:load -n --env=prod