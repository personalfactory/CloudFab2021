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
            include('../sql/script.php');
            include('../sql/script_accessorio.php');
            
//            ini_set(display_errors, "1");

//Gestione degli errori relativa ai nuovi dati modificati
//Verifico che i nuovi valori siano stati settati e non nulli
            $errore = false;
            $messaggio = $msgErroreVerificato . '<br />';


            if (!isset($_POST['Codice']) || trim($_POST['Codice']) == "") {

                $errore = true;
                $messaggio = $messaggio . ' ' . $msgErrCodice . '<br />';
            }
            if (!isset($_POST['Descrizione']) || trim($_POST['Descrizione']) == "") {

                $errore = true;
                $messaggio = $messaggio . ' ' . $msgErrDescri . '<br />';
            }

//Ricavo i nuovi valori dei campi mandati tramite POST
            $Codice = str_replace("'", "''", $_POST['Codice']);
            $CodiceOld = str_replace("'", "''", $_POST['CodiceOld']);
            $UniMisura = str_replace("'", "''", $_POST['UnitaMisura']);
            $Descrizione = str_replace("'", "''", $_POST['Descrizione']);
            $PreAcq = str_replace("'", "''", $_POST['PreAcq']);
            list($IdAzienda, $NomeAzienda) = explode(';', $_POST['Azienda']);
            
//Verifica esistenza 
            if ($Codice != $CodiceOld) {
                $result = verificaEsistenzaAccessorio($Codice);

                if (mysql_num_rows($result) != 0) {
                    //Se entro nell'if vuol dire che esiste
                    $errore = true;
                    $messaggio = $messaggio . ' ' . $msgErrAccessorioEsistente . '<br />';
                }
            }
            $messaggio = $messaggio . '<a href="javascript:history.back()">' . $msgRicontrollaDati . '</a>';

            if ($errore) {
                //Ci sono errori quindi non salvo
                echo '<div id="msgErr">' . $messaggio . '</div>';
            } else {

                $modificaAccessorio = true;

                begin();
                
                $modificaAccessorio = modificaAccessorio($CodiceOld, $Codice, $Descrizione, $UniMisura, $PreAcq,$IdAzienda);

                if (!$modificaAccessorio) {

                    rollback();

                    echo '<div id="msgErr">' . $msgErroreVerificato . '' . $msgErrContattareAdmin . ' <a href="gestione_accessori.php">' . $msgOk . '</a></div>';
                } else {

                    commit();

                    echo $msgModificaCompletata . ' <a href="gestione_accessori.php">' . $msgOk . '</a>';
                }
            }
            ?>
        </div>
    </body>
</html>