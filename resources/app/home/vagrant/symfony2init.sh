#!/bin/bash

cd /vagrant

/usr/local/bin/composer update --prefer-source

app/console --env=test doctrine:database:drop --force -n
app/console --env=test doctrine:database:create -n
app/console --env=test doctrine:schema:create -n
app/console --env=test doctrine:fixtures:load -n

app/console doctrine:database:drop --force -n
app/console doctrine:database:create -n
app/console doctrine:schema:create -n
app/console doctrine:fixtures:load -n



