git stash
git pull origin develop
php-cli app/console cache:clear --env=preprod
php-cli app/console doctrine:schema:update --force --env=preprod
php-cli app/console assets:install