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
            include('../sql/script_messaggio_macchina.php');
            include('../sql/script.php');
            include('../sql/script_dizionario.php');


            $IdMessaggio = $_POST['IdMessaggio'];
            $MessaggioOld = $_POST['MessaggioOld'];
            $MessaggioMacchina = str_replace("'", "''", $_POST['MessaggioMacchina']);

########### GESTIONE ERRORI QUERY ##############################################      
            $insertStorico = true;
            $updateServerdbDizionario = true;
            $selectDizionario = true;
            $updateServerdbDizionario = true;

########### GESTIONE ERRORI SUL INPUT ##########################################
            $errore = false;
            $messaggio = $msgErroreVerificato . '<br />';

            if (!isset($MessaggioMacchina) || trim($MessaggioMacchina) == "") {

                $errore = true;
                $messaggio = $messaggio . ' ' . $msgErrCampoMsgMacchinaVuoto . '<br />';
            }

//Verifica esistenza 
            $messaggio = $messaggio . '<a href="javascript:history.back()">' . $msgRicontrollaDati . '</a>';

            if ($errore) {
                //Ci sono errori quindi non salvo
                echo $messaggio;
            } else {
//Inserisco il vecchio record nello storico delle categorie prima di modificarlo nella tabella corrente su serverdb
                include('../Connessioni/storico.php');
                include('../Connessioni/serverdb.php');

                //##################### INIZIO TRANSAZIONE #############################

                begin();

                //#################### STORICIZZO ######################################

                $insertStorico = insertStoricoMessaggioMacchina($IdMessaggio);
//#################### MODIFICO SU SERVERDB ####################################

                $updateServerdb = updateServerDBMessaggioMacchina($IdMessaggio, $MessaggioMacchina, dataCorrenteInserimento());


//##################### OPERAZIONI SUL DIZIONARIO ##############################
                if ($MessaggioOld !=$MessaggioMacchina) {
                    //Se il messaggio modificato era già stato caricato sul dizionario, 
                    //allora bisogna andare a modificarlo anke nel dizionario 
                    //il vocabolo deve essere modificato in tutte le lingue 
                    //e coincide finchè non verrà nuovamente tradotto                
                    $updateServerdbDizionario = updateServerDBDizionario($IdMessaggio, $MessaggioMacchina, 3);
                }
//################## FINE AGGIORNAMENTO DIZIONARIO #############################

                if (!$insertStorico OR !$updateServerdb OR !$updateServerdbDizionario) {

                    rollback();
                    echo $msgTransazioneFallita . ' ' . $msgErrContattareAdmin . '!';
                } else {

                   
                   commit();
                    mysql_close();
                    echo $msgModificaCompletata . ' ';
                    echo '<a href="gestione_messaggi.php">' . $msgOk . '</a>';
                }
            }
            ?>
        </div>
    </body>
</html>