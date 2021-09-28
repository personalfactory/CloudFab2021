<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <?php include('../include/validator.php'); ?>
    <head>
        <?php include('../include/header.php'); ?>
    </head>
    <body>
        <div id="mainContainer">
            <?php
            include('../include/menu.php');
            include('../include/gestione_date.php');
            include('../Connessioni/serverdb.php');
            include('../Connessioni/storico.php');
            include('../sql/script.php');
            include('../sql/script_codice.php');
            include('../sql/script_dizionario.php');


//Ricavo i nuovi valori dei campi mandati tramite POST
            $IdCodice = $_POST['IdCodice'];
            $TipoCodice = str_replace("'", "''", $_POST['TipoCodice']);
            $Descrizione = str_replace("'", "''", $_POST['Descrizione']);
            $DescrizioneOld = str_replace("'", "''", $_POST['DescrizioneOld']);

            list($IdAzienda, $NomeAzienda) = explode(';', $_POST['Azienda']);
//Gestione degli errori relativa ai nuovi dati modificati
//Verifico che i nuovi valori siano stati settati e non nulli
            $errore = false;
            $messaggio = $msgErroreVerificato . '<br/>';


            if (!isset($TipoCodice) || trim($TipoCodice) == "") {

                $errore = true;
                $messaggio = $messaggio . ' ' . $msgErrCodice . '<br />';
            }
            if (!isset($Descrizione) || trim($Descrizione) == "") {

                $errore = true;
                $messaggio = $messaggio . ' ' . $msgErrDescri . '<br />';
            }

//Verifica esistenza 
//Verifico che non ci sia in tabella un record con gli stessi valori(descrizioni) 
//e con Id diverso da quello che si sta modificando


            $result = verificaEsistenzaFamiglia($IdCodice, $TipoCodice);

            if (mysql_num_rows($result) != 0) {
                //Se entro nell'if vuol dire che esiste
                $errore = true;
                $messaggio = $messaggio . ' ' . $msgErrEsisteFamiglia . ' <br />';
            }

            $messaggio = $messaggio . '<a href="javascript:history.back()">' . $msgRicontrollaDati . '</a>';

            if ($errore) {
                //Ci sono errori quindi non salvo
                echo $messaggio;
            } else {

                $insertStorico = true;
                $updateCodServerdb = true;
                $updateServerdbDizionario = true;

                begin();

//Inserisco il vecchio record nello storico  
//prima di modificarlo nella tabella corrente su serverdb

                $insertStorico = insertStoricoCodice($IdCodice);

//Modifico il record nella tabella corrente [codice] di serverdb, 
//salvando i nuovi valori dei campi mandati tramite POST 
//e aggiornando il campo dt_abilitato con data corrente.
                $updateCodServerdb = updateCodice($IdCodice, $TipoCodice, $Descrizione, dataCorrenteInserimento(), $IdAzienda);

//##################### OPERAZIONI SUL DIZIONARIO ##############################
                if ($DescrizioneOld != $Descrizione) {
                    
                    //Se la descrizione modificato era già stato caricata sul dizionario, 
                    //allora bisogna andare a modificarla anke nel dizionario 
                    //il vocabolo deve essere modificato in tutte le lingue 
                    //e coincide finchè non verrà nuovamente tradotto             
                    $updateServerdbDizionario = updateServerDBDizionario($IdCodice, $Descrizione, 5);
                }
//################## FINE AGGIORNAMENTO DIZIONARIO #############################

                if (!$insertStorico OR !$updateCodServerdb OR !$updateServerdbDizionario) {

                    rollback();
                    echo $msgTransazioneFallita . ' <a href="gestione_codici.php">' . $msgErrContactAdmin . '</a><br/>';
                } else {

                    commit();
//                    echo "descri ".$DescrizioneOld."-->".$Descrizione."<br/>";
                    echo $msgInserimentoCompletato . ' <a href="gestione_codici.php">' . $msgTornaAlleFamiglie . '</a><br/>';
                    mysql_close();
                }
            }
            ?>
        </div>
    </body>
</html>