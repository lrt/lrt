./reset_bdd.sh --env=test

phpunit -c app --strict $1 $2 $3 $4 | cat