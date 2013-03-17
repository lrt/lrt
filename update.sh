git stash
git pull
php-cli app/console cache:clear --env=preprod
php-cli app/console doctrine:schema:update --force --env=preprod
php-cli app/console assets:install