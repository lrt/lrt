php app/console doctrine:schema:drop -n --force --env=test
php app/console doctrine:schema:create -n --env=test
php app/console doctrine:schema:update --force --env=test
php app/console doctrine:fixtures:load -n --env=test

vendor/bin/behat @UserBundle --ansi $1 $2 $3 $4 | cat