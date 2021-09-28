<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <?php include('../include/validator.php'); ?>
    <head>
        <?php include('../include/header.php'); ?>
    </head>
    <body>
  <div id="labContainer">
        <?php
        include('../include/menu.php');
        include('../include/gestione_date.php');
        include('../Connessioni/serverdb.php');
        include('sql/script.php');
        include('sql/script_lab_parametro.php');
        
       
            //###################### CONTROLLO INPUT ###############################
            $errore = false;
            $messaggio = $msgErroreVerificato . '<br />';

            if (!isset($_POST['NomeParametro']) || trim($_POST['NomeParametro']) == "") {

                $errore = true;
                $messaggio = $messaggio . ' ' . $msgErroreNome . '<br />';
            }
            if (!isset($_POST['Descrizione']) || trim($_POST['Descrizione']) == "") {

                $errore = true;
                $messaggio = $messaggio . ' ' . $msgErrDescri . '<br />';
            }
            if (!isset($_POST['UnitaMisura']) || trim($_POST['UnitaMisura']) == "") {

                $errore = true;
                $messaggio = $messaggio . ' ' . $msgErrUnMisura . '<br />';
            }
            if (!isset($_POST['Tipo']) || trim($_POST['Tipo']) == "") {

                $errore = true;
                $messaggio = $messaggio . ' ' . $msgErrTipo . '<br />';
            }

            //############### VERIFICA ESISTENZA ###################################

            $result = verificaEsistenzaNewPar($_POST['NomeParametro']);

            if (mysql_num_rows($result) != 0) {
                //Se entro nell'if vuol dire che esiste
                $errore = true;
                $messaggio = $messaggio . ' ' . $msgErrParEsistente . '<br />';
            }
            list($IdAzienda, $NomeAzienda) = explode(';', $_POST['Azienda']);

            $messaggio = $messaggio . '<a href="javascript:history.back()">' . $msgRicontrollaDati . '</a>';


            if ($errore) {
                //Ci sono errori quindi non salvo
                echo '<div id="msgErr">' . $messaggio . '</div>';
            } else {

                $NomeParametro = str_replace("'", "''", $_POST['NomeParametro']);
                $Descrizione = str_replace("'", "''", $_POST['Descrizione']);
                $UnitaMisura = str_replace("'", "''", $_POST['UnitaMisura']);
                $Tipo = str_replace("'", "''", $_POST['Tipo']);

                //Inserisco, non ci sono errori
                $insertParametro = true;
                begin();
                $insertParametro = inserisciNuovoParametro($NomeParametro, $Descrizione, $UnitaMisura, $Tipo, dataCorrenteInserimento(),$_SESSION['id_utente'], $IdAzienda);

                if (!$insertParametro) {
                    rollback();
                    echo '<div id="msgErr">' . $msgErroreVerificato . '' . $msgErrContattareAdmin . ' <a href="gestione_lab_parametri.php">' . $msgOk . '</a></div>';
                } else {
                    commit();
                   echo $msgInserimentoCompletato . ' <a href="gestione_lab_parametri.php">' . $msgOk . '</a>';
                }
            }
            ?>
        </div>
    </body>
</html>
