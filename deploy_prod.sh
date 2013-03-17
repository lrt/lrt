git stash
git pull
php-cli app/console cache:clear --env=prod
php-cli app/console doctrine:schema:update --force --env=prod
php-cli app/console assets:install