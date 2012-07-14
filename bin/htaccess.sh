#!/bin/bash

rm web/.htaccess

for file in htaccess/*; do
    cat $file >> web/.htaccess
done
