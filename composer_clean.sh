#!/bin/bash
CURRENT_DIR="$(cd $1;cd ..;pwd)"
echo $CURRENT_DIR
chmod -R 666 $1
echo "Permission changed"
rm -Rf $1
echo ".git directory removed"
git rm --cached -r $CURRENT_DIR
echo "Cached Git Data removed"
git add $CURRENT_DIR 
echo "Adding directory to GIT"