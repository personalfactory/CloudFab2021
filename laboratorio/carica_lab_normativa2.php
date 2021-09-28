<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <?php include('../include/validator.php'); ?>
    <head>
        <?php include('../include/header.php'); ?>
    </head>
    <body>
        <?php
        if($DEBUG) ini_set(display_errors, "1"); 
       
        include('../include/gestione_date.php');
        include('../Connessioni/serverdb.php');
        include('sql/script.php');
        include('sql/script_lab_normativa.php');
        
        ?>
        <div id="labContainer">
            <?php
             include('../include/menu.php');
            //###################### CONTROLLO INPUT ###############################
            $errore = false;
            $messaggio = $msgErroreVerificato . '<br />';

            if (!isset($_POST['Normativa']) || trim($_POST['Normativa']) == "") {

                $errore = true;
                $messaggio = $messaggio . ' ' . $msgErroreNormativa . '<br />';
            }
            if (!isset($_POST['Descrizione']) || trim($_POST['Descrizione']) == "") {

                $errore = true;
                $messaggio = $messaggio . ' ' . $msgErrDescri . '<br />';
            }
            

            //############### VERIFICA ESISTENZA ###################################

            $result = verificaEsistenzaNewNormativa($_POST['Normativa']);

            if (mysql_num_rows($result) != 0) {
                //Se entro nell'if vuol dire che esiste
                $errore = true;
                $messaggio = $messaggio . ' ' . $msgErrNormativaEsistente . '<br />';
            }


            $messaggio = $messaggio . '<a href="javascript:history.back()">' . $msgRicontrollaDati . '</a>';


            if ($errore) {
                //Ci sono errori quindi non salvo
                echo '<div id="msgErr">' . $messaggio . '</div>';
            } else {

                $Normativa = str_replace("'", "''", $_POST['Normativa']);
                $Descrizione = str_replace("'", "''", $_POST['Descrizione']);
                list($IdAzienda, $NomeAzienda) = explode(';', $_POST['Azienda']);
                //Inserisco, non ci sono errori
                $insertNormativa = true;
                begin();
                $insertNormativa = inserisciNuovaNormativa($Normativa, $Descrizione,$_SESSION['id_utente'],$IdAzienda);

                if (!$insertNormativa) {
                    rollback();
                    echo '<div id="msgErr">' . $msgErroreVerificato . '' . $msgErrContattareAdmin . ' <a href="gestione_lab_parametri.php">' . $msgOk . '</a></div>';
                } else {
                    commit();
                   echo $msgInserimentoCompletato . ' <a href="gestione_lab_normativa.php">' . $msgOk . '</a>';
                }
            }
            ?>
        </div>
    </body>
</html>
