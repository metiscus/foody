#!/bin/bash

cd "$(dirname "$0")"

echo deploying..
rm -rf /var/www/html/*
cp -rf ../*.php /var/www/html/
cp -rf ../Slim /var/www/html
cp -f ../.htaccess /var/www/html
echo done..
