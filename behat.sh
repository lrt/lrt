php app/console doctrine:database:drop -n --force --env=test
php app/console doctrine:database:create -n --env=test
php app/console doctrine:schema:update --force --env=test
php app/console doctrine:fixtures:load --env=test -n
vendor/bin/behat @GgoBundle | cat
vendor/bin/behat @UserBundle | cat