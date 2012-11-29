php app/console doctrine:schema:drop -n --force $1
php app/console doctrine:schema:create $1
php app/console doctrine:fixtures:load -n $1
