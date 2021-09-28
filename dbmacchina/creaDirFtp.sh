#!/bin/sh -e

#ARGOMENTI
#$1 idMacchina
#$2 userFtp
#$3 backupFilePath
#$4 backupFileName
#$5 zipPassword

#- PROCEDURA
#- Compressione del file
#- Connessione al server FTP
#- Creazione della cartella e delle sottocartelle
#- Posizionamento nella cartella bkp0 del FTP 
#- Caricamento del file

cd $3
zip --password $5 origamidb.zip $4

HOST='195.110.124.133'
USERADMIN='francesco.tassone'
PASSWDADMIN='924W56fra_'

cd $3

ftp -n $HOST <<END_SCRIPT
quote USER $USERADMIN
quote PASS $PASSWDADMIN

#mkdir $2 
cd $2
mkdir s2m
cd s2m 
mkdir old
cd ..
mkdir bkp0
cd bkp0
mkdir old
cd ..
mkdir sft

cd bkp0

#put $4
put origamidb.zip
quit
END_SCRIPT
exit 0
