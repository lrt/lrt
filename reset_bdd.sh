php app/console doctrine:schema:drop -n --force $1
php app/console doctrine:schema:create -n $1
php app/console doctrine:schema:update --force $1
php app/console doctrine:fixtures:load -n $1
