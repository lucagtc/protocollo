#!/bin/bash

app/console assets:install web --symlink

#Compilazione e compattazione di js e css
app/console --env=prod --no-debug assetic:dump
