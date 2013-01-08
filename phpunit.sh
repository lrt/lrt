php app/console doctrine:schema:drop -n --force --env=test
php app/console doctrine:schema:create --env=test
php app/console doctrine:fixtures:load -n --env=test

php app/console cache:clear --env=test --no-debug --no-warmup
phpunit -c app --strict $1 $2 $3 $4 | cat