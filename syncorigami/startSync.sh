#!/bin/bash

# RICORDARSI DI CAMBIARE I PERMESSI DI ESECUZIONE ALLO SCRIPT
# chmod 777 startSync.sh

# LO SCRIPT PER ESSERE ESEGUITO
# - o si chiama con il percorso assoluto
# - o si mette nel path dentro /etc/environment e lo chiami da dove vuoi

# es. java -jar dist/SyncOrigami.jar uploadAggiornamentoDaServerPerMacchina 1

#$JAR_FILE=$1
#$MAIN_CLASS=$2
#$PROP_FILE=$3


cd /var/www/CloudFab/syncorigami/SyncOrigami

java -jar $1 $2 $3


