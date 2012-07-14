#!/bin/bash

app/console cache:clear
app/console --env=prod cache:clear --no-debug

#chmod ugo+wrx -R app/logs app/cache
