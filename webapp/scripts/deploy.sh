#!/bin/bash

cd "$(dirname "$0")"

echo deploying webapp..
#rm -rf /var/www/html/*
rm -rf /var/www/html/*.php Slim .htaccess
cp -rf ../*.php /var/www/html/
cp -rf ../Slim /var/www/html
cp -f ../.htaccess /var/www/html
echo done..

echo deploying site..
cp -rf ../../site/* /var/www/html/
echo done..
