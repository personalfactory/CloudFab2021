<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <?php include('../include/validator.php'); ?>
    <head>
        <?php include('../include/header.php'); ?>
    </head>
    <body>
        <div id="mainContainer">
            <?php
//            ini_set(display_errors, "1");
            include('../include/menu.php');
            include('../include/gestione_date.php');
            include('../Connessioni/serverdb.php');
            include('../sql/script.php');
            include('../sql/script_macchina.php');
            include('../sql/script_parametro_sing_mac.php');
            include('../sql/script_valore_par_sing_mac.php');


//####################### CONTROLLO INPUT ######################################

            $errore = false;
            $erroreEs = false;
            $messaggio = $msgErroreVerificato . '<br/>';
            $messaggioEs = $msgErroreVerificato . '<br/>';

            if (!isset($_POST['IdParametro']) || trim($_POST['IdParametro']) == "") {

                $errore = true;
                $messaggio = $messaggio . $msgErrCampoIdParVuoto . '<br />';
            }
            if (!isset($_POST['NomeParametro']) || trim($_POST['NomeParametro']) == "") {

                $errore = true;
                $messaggio = $messaggio . $msgErrCampoNomeParVuoto . '<br />';
            }
            if (!isset($_POST['DescriParametro']) || trim($_POST['DescriParametro']) == "") {

                $errore = true;
                $messaggio = $messaggio . $msgErrCampoDescriParVuoto . '<br />';
            }
            if (!isset($_POST['ValoreBase']) || trim($_POST['ValoreBase']) == "") {

                $errore = true;
                $messaggio = $messaggio . $msgErrCampoValBaseVuoto . '<br />';
            }
            //Verifica tipo di dati
            if (!is_numeric($_POST['IdParametro'])) {

                $errore = true;
                $messaggio = $messaggio . ' - ' . $filtroId . ' ' . $msgErrDeveEssereIntero . '<br />';
            }

            if ($errore) {

                //####################### RECUPERO POST ########################################
                //Ci sono errori quindi non salvo
                echo $messaggio = $messaggio . '<a href="javascript:history.back()">' . $msgRicontrollaDati . '</a>';
            } else { //Non ci sono errori quindi salvo
                //####################### RECUPERO POST ########################################
                $IdParametro = $_POST['IdParametro'];
                $NomeParametro = str_replace("'", "''", $_POST['NomeParametro']);
                $DescriParametro = str_replace("'", "''", $_POST['DescriParametro']);
                $ValoreBase = str_replace("'", "''", $_POST['ValoreBase']);

                $result = findParSMByIdNome($IdParametro, $NomeParametro);

                if (mysql_num_rows($result) != 0) {
                    //Se entro nell'if vuol dire che esiste
                    $erroreEs = true;
                    $messaggioEs = $messaggioEs . " " . $msgDuplicaRecord . '<br />';
                }

                if ($erroreEs) {
                    echo $messaggioEs . '<a href="javascript:history.back()">' . $msgRicontrollaDati . '</a>';
                } else {
//###################### SALVATAGGIO NEL DB ####################################

                    $insertParametro = true;
                    $insertValore = true;
                    $erroreTransazione = false;

                    begin();
                    $insertParametro = insertNewParSM($IdParametro, $NomeParametro, $DescriParametro, $ValoreBase, dataCorrenteInserimento());

                    $valoreIniziale = "";
                    $valoreMac = "";

                    $sqlMacchine = findAllMacchine("id_macchina");

                    while ($rowMac = mysql_fetch_array($sqlMacchine)) {

                        $insertValore = insertValoreParSM($IdParametro, $ValoreBase, $valoreIniziale, $valoreMac, $rowMac['id_macchina'], "1", dataCorrenteInserimento());

                        if (!$insertValore)
                            $erroreTransazione = true;
                    }



                    if ($erroreTransazione OR !$insertParametro) {

                        rollback();
                        echo "</br>" . $msgTransazioneFallita;
                        echo "</br>InsertParametro : " . $insertParametro;
                        echo "</br>erroreTransazione : " . $erroreTransazione;
                        echo '<a href="gestione_parametri_singola.php">' . $msgOk . '</a>';
                    } else {

                        commit();

                        echo $msgInfoTransazioneRiuscita . " ";
                        echo '<a href="gestione_parametri_singola.php">' . $msgOk . '</a>';
                    }
                }
            }
            ?>


        </div>
    </body>
</html>
