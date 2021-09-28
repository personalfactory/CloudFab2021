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
            include ('../sql/script_codice.php');
            include ('../sql/script.php');

            $TipoCodice = str_replace("'", "''", $_POST['TipoCodice']);
            $Descrizione = str_replace("'", "''", $_POST['Descrizione']);

//Gestione degli errori
//Inizializzazione dell'errore e del messaggio di errore
            $errore = false;
            $messaggio = $msgErroreVerificato . '<br />';

//Verifica che il tipo codice e la descrizione siano settati e non vuoti
            if (!isset($TipoCodice) || trim($TipoCodice) == "") {

                $errore = true;
                $messaggio = $messaggio . ' - ' . $msgCampoVuoto . ' : ' . $filtroTipoCodice . ' !<br />';
            }
            if (!isset($Descrizione) || trim($Descrizione) == "") {

                $errore = true;
                $messaggio = $messaggio . ' - ' . $msgCampoVuoto . ' : ' . $filtroDescrizione . ' !<br />';
            }

            list($IdAzienda, $NomeAzienda) = explode(';', $_POST['Azienda']);
            //Verifica esistenza drelativa al tipo_codice  
            //$query="SELECT * FROM codice WHERE tipo_codice = '".$TipoCodice."'";
            //$result=mysql_query($query,$connessione) or die("Errore 125 :".mysql_error()); 

            $result = findCodiceByTipo($TipoCodice);

            if (mysql_num_rows($result) != 0) {
                //Se entro nell'if vuol dire che esiste
                $errore = true;
                $messaggio = $messaggio . $msgDuplicaRecord . '<br />';
            }

            $messaggio = $messaggio . '<a href="javascript:history.back()">' . $msgRicontrollaDati . '</a>';

            $insCodice = true;
            //Controllo sulla variabile errore
            if ($errore) {
                //Ci sono errori quindi non salvo
                echo $messaggio;
            } else {
                //Inserisco perch� non ci sono errori

                begin();
                /*
                  $query="INSERT INTO codice (tipo_codice, descrizione,abilitato,dt_abilitato)
                  VALUES ( '".$TipoCodice.
                  "','".$Descrizione.
                  "',1,
                  '".dataCorrenteInserimento()."')";
                  $result=mysql_query($query,$connessione) or die("Errore 126".mysql_error());
                 */
                $insCodice = insertCodice($TipoCodice, $Descrizione, dataCorrenteInserimento(),$_SESSION['id_utente'],$IdAzienda);


                if (!$insCodice) {

                    rollback();
                    echo '<div id="msgErr">' . $msgTransazioneFallita . '! ' . $msgErrContactAdmin . '!</div>';
                    echo '<a href="gestione_codici.php">' . $msgTornaAiCodici . '</a><br/>';
                } else {

                    commit();
                    mysql_close();
                    echo($msgInserimentoCompletato . ' <a href="gestione_codici.php">' . $msgTornaAiCodici . '</a><br/>');
                }
            }
            ?>
        </div>
    </body>
</html>
