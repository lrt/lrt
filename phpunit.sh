php app/console doctrine:schema:drop -n --force --env=test
php app/console doctrine:schema:create -n --env=test
php app/console doctrine:schema:update --force --env=test
php app/console doctrine:fixtures:load --env=test -n

phpunit -c app | cat | grep -v Xdebug