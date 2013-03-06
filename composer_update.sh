#!/bin/bash
echo "Configuration Proxy"
http_proxy=http://163.110.224.33:8080
export http_proxy
echo "MAJ via composer.json"
echo "MAJ Composer"
php composer.phar self-update
php composer.phar update
echo "Clean"
sh composer_clean.sh