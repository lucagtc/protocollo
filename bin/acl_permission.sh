#!/bin/bash

#Utente con cui viene eseguito apache2
WEBUSER="www-data"
#Utente attualmente loggato
ACTUALUSER=$(whoami)

sudo setfacl -R -m u:$WEBUSER:rwx -m u:$ACTUALUSER:rwx app/cache app/logs
sudo setfacl -dR -m u:$WEBUSER:rwx -m u:$ACTUALUSER:rwx app/cache app/logs
