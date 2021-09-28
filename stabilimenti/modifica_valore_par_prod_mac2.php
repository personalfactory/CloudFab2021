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
            include('../sql/script_valore_par_prod_mac.php');
            include('../sql/script.php');

            //############# STRINGA UTENTI-AZIENDE VISIBILI ###############################
            //Stringa contenente l'elenco degli id degli utenti e delle aziende prop visibili 
            //dall'utente loggato   
            $strUtentiAziendeProd = getStrUtAzVisib($_SESSION['objPermessiVis'], 'prodotto');
            $sqlPar = findValoreParProdByIdMacchina($_SESSION['IdMacchina'], $_SESSION['Filtro'], $_SESSION['IdValPM'], $_SESSION['IdParPM'], $_SESSION['NomeVariabile'], $_SESSION['NomeProdotto'], $_SESSION['ValoreVariabile'], $_SESSION['DtAbilitato'], $strUtentiAziendeProd);

//############### CONTROLLO INPUT ##############################################
            $errore = false;
            $messaggio = $msgErroreVerificato . '<br/>';

            $erroreResult = false;
            $insertStorico = true;
            $updateServerdb = true;

            $NParEr = 1;
            while ($rowParEr = mysql_fetch_array($sqlPar)) {

                $Valore = $_POST['Valore' . $rowParEr['id_val_pm']];

                //Controllo sui valori eventualmente modificati 
                if (!isset($Valore) || trim($Valore) == "") {

                    $errore = true;
                    $messaggio = $messaggio . " " . $titleValParNumSac . "(" . $rowParEr['descri_variabile'] . ") " . $msgVuoto . "!<br />";
                }
                $NParEr++;
            }

            $messaggio = $messaggio . '<a href="javascript:history.back()">' . $msgRicontrollaDati . '</a>';

            if ($errore) {
                //Ci sono errori quindi non effettuo la modifica e visualizzo il messaggio di errore
                echo $messaggio;
            } else {// Non ci sono errori quindi posso salvare
                //################### INIZIO TRANSAZIONE #######################################            
                begin();
                mysql_data_seek($sqlPar, 0);


                $NPar = 1;
                while ($rowPar = mysql_fetch_array($sqlPar)) {

                    $Valore = $_POST['Valore' . $rowPar['id_val_pm']];

                    $ValoreOld = $rowPar['valore_variabile'];
//                    echo "Valore New : " . $Valore;
//                    echo "</br>Valore Old : " . $ValoreOld;
                    //Inserisco nello storico i vecchi record relativi ai valori parametri che sono stati modificati
                    //che si stanno modificando
                    if ($Valore != $ValoreOld) {
                        $insertStorico = insertIntoValParProdMac($rowPar['id_val_pm'], $rowPar['id_prodotto'], $rowPar['id_par_pm'], $_SESSION['IdMacchina'], $rowPar['valore_variabile'], $rowPar['abilitato'], $rowPar['dt_abilitato']);

                        if (!$insertStorico) {
                            $erroreResult = true;
                        }
                    }
                    //Salvo la modifica nella tabella valore_par_comp di serverd
                    $updateServerdb = updateValoreParProdMac($Valore, dataCorrenteInserimento(), $rowPar['id_par_pm'], $rowPar['id_prodotto'], $_SESSION['IdMacchina']);

                    if (!$updateServerdb) {
                        $erroreResult = true;
                    }

                    $NPar++;
                }// end while finiti i parametri 

                if ($erroreResult OR ! $updateServerdb OR ! $insertStorico) {

                    rollback();
                    echo $msgTransazioneFallita . ' ' . $msgErrContattareAdmin . " ";
                    echo '<a href="modifica_valore_par_prod_mac.php?IdMacchina=' . $_SESSION['IdMacchina'] . '">' . $msgOk . '</a>';
                } else {

                    commit();
                    mysql_close();
                    echo $msgInfoTransazioneRiuscita . " ";
                    echo '<a href="modifica_valore_par_prod_mac.php?IdMacchina=' . $_SESSION['IdMacchina'] . '">' . $msgOk . '</a>';
                }
            }//End if errore
            ?>

        </div>
    </body>
</html>

