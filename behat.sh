#php app/console cache:clear --env=test --no-debug --no-warmup
#./reset_bdd.sh --env=test
#vendor/bin/behat @UserBundle --ansi $1 $2 $3 $4 | cat
vendor/bin/behat @AdhesionBundle --ansi $1 $2 $3 $4 | cat
#vendor/bin/behat @CMSBundle --ansi $1 $2 $3 $4 | cat
#vendor/bin/behat @SiteBundle --ansi $1 $2 $3 $4 | cat