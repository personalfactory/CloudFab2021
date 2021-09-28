<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <?php include('../include/validator.php'); ?>
    <head>
        <?php include('../include/header.php'); ?>
    </head>
    <body>
<div id="labContainer">
        <?php
        if ($DEBUG)
        ini_set(display_errors, "1");
        include('../include/menu.php');
        include('../include/gestione_date.php');
        include('../Connessioni/serverdb.php');
        include('sql/script_lab_normativa.php');
        include('sql/script.php');
       
            $Normativa = $_POST['Normativa'];
          
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
                       
            list($IdAzienda, $NomeAzienda) = explode(';', $_POST['Azienda']);
            
            $messaggio = $messaggio . '<a href="javascript:history.back()">' . $msgRicontrollaDati . '</a>';


            if ($errore) {
                //Ci sono errori quindi non salvo
                echo '<div id="msgErr">' . $messaggio . '</div>';
            } else {

                $Normativa = str_replace("'", "''", $_POST['Normativa']);
                $Descrizione = str_replace("'", "''", $_POST['Descrizione']);
                
                //Inserisco perche non ci sono errori
                $updateNorm = true;
                begin();
                
                $updateNorm = modificaLabNormativa($Normativa, $Descrizione, dataCorrenteInserimento(),$IdAzienda);
                        
                
                if (!$updateNorm) {
                    rollback();
                    echo '<div id="msgErr">' . $msgErroreVerificato . '' . $msgErrContattareAdmin . ' <a href="gestione_lab_normativa.php">' . $msgOk . '</a></div>';
                } else {
                    commit();
                    echo $msgModificaCompletata . ' <a href="gestione_lab_normativa.php">' . $msgOk . '</a>';
                }
            }
            ?>
        </div>
    </body>
</html>
