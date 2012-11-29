./reset_bdd.sh --env=test
vendor/bin/behat @SiteBundle $1 $2 $3 $4 | cat
vendor/bin/behat @UserBundle $1 $2 $3 $4 | cat