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
            include('../sql/script_valore_par_comp.php');
            include('../sql/script.php');

            //############# STRINGA UTENTI-AZIENDE VISIBILI ###############################
            //Stringa contenente l'elenco degli id degli utenti e delle aziende prop visibili 
            //dall'utente loggato   
            $strUtentiAziendeComp = getStrUtAzVisib($_SESSION['objPermessiVis'], 'componente');
            $sqlPar = findValoreParCompByIdMacchina($_SESSION['IdMacchina'], $_SESSION['Filtro'], $_SESSION['IdValComp'], $_SESSION['IdParComp'], $_SESSION['NomeVariabile'], $_SESSION['DescriComponente'], $_SESSION['ValoreVariabile'], $_SESSION['DtAbilitato'], $_SESSION['ValoreIniziale'], $_SESSION['DtValoreIniziale'], $_SESSION['ValoreMacchina'], $_SESSION['DtModificaMac'], $_SESSION['DtAgg'], $strUtentiAziendeComp);

//############### CONTROLLO INPUT ##############################################
            $errore = false;
            $messaggio = $msgErroreVerificato . '<br/>';

            $erroreResult = false;
            $insertStorico = true;
            $updateServerdb = true;

            $NParEr = 1;
            while ($rowParEr = mysql_fetch_array($sqlPar)) {

                $Valore = $_POST['Valore' . $rowParEr['id_val_comp']];

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

                    $Valore = $_POST['Valore' . $rowPar['id_val_comp']];

                    //Inserisco nello storico i vecchi record relativi ai valori parametri 
                    //che si stanno modificando
                    $insertStorico = insertIntoValParCompStorico($rowPar['id_val_comp'], $rowPar['id_comp'], $rowPar['id_par_comp'], $_SESSION['IdMacchina'], $rowPar['valore_variabile'], $rowPar['abilitato'], $rowPar['dt_abilitato']);

                    //Salvo la modifica nella tabella valore_par_comp di serverd
                    $updateServerdb = updateValoreParComp($Valore, dataCorrenteInserimento(), $rowPar['id_par_comp'], $rowPar['id_comp'], $_SESSION['IdMacchina']);

                    if (!$insertStorico OR ! $updateServerdb) {
                        $erroreResult = true;
                    }

                    $NPar++;
                }// end while finiti i parametri 

                if ($erroreResult OR ! $updateServerdb OR ! $insertStorico) {

                    rollback();
                    echo $msgTransazioneFallita . ' ' . $msgErrContattareAdmin . " ";
                    echo '<a href="modifica_valore_par_comp_stab.php?IdMacchina=' . $_SESSION['IdMacchina'] . '">' . $msgOk . '</a>';
//          echo "</br>erroreResult : " . $erroreResult;
//          echo "</br>updateServerdb : " . $updateServerdb;
//          echo "</br>insertStorico : " . $insertStorico;
//          echo "</br>sqlPar : " . $sqlPar;
//          echo "</br> SESSION['IdMacchina'] : " . $_SESSION['IdMacchina'];
//          echo "</br> SESSION['IdValComp'] : " . $_SESSION['IdValComp'];
//          echo "</br> SESSION['IdParComp'] : " . $_SESSION['IdParComp'];
//          echo "</br> SESSION['NomeVariabile'] : " . $_SESSION['NomeVariabile'];
//          echo "</br> SESSION['DescriComponente'] : " . $_SESSION['DescriComponente'];
//          echo "</br> SESSION['ValoreVariabile'] : " . $_SESSION['ValoreVariabile'];
//          echo "</br> SESSION['DtAbilitato'] : " . $_SESSION['DtAbilitato'];
//          echo "</br> SESSION['ValoreIniziale'] : " . $_SESSION['ValoreIniziale'];
//          echo "</br> SESSION['DtValoreIniziale'] : " . $_SESSION['DtValoreIniziale'];
//          echo "</br> SESSION['ValoreMacchina'] : " . $_SESSION['ValoreMacchina'];
//          echo "</br> SESSION['DtModificaMac'] : " . $_SESSION['DtModificaMac'];
//          echo "</br> SESSION['DtAgg'] : " . $_SESSION['DtAgg'];
                } else {

//                echo "</br>erroreResult : ".$erroreResult;
//                echo "</br>updateServerdb : ".$updateServerdb;
//                echo "</br>insertStorico : ".$insertStorico;
//                echo "</br>sqlPar : ".$sqlPar;
//                    echo "</br> SESSION['IdValComp'] : " . $_SESSION['IdValComp'];
//                    echo "</br> SESSION['IdParComp'] : " . $_SESSION['IdParComp'];
//                    echo "</br> SESSION['NomeVariabile'] : " . $_SESSION['NomeVariabile'];
//                    echo "</br> SESSION['DescriComponente'] : " . $_SESSION['DescriComponente'];
//                    echo "</br> SESSION['ValoreVariabile'] : " . $_SESSION['ValoreVariabile'];
//                    echo "</br> SESSION['DtAbilitato'] : " . $_SESSION['DtAbilitato'];
//                    echo "</br> SESSION['ValoreIniziale'] : " . $_SESSION['ValoreIniziale'];
//                    echo "</br> SESSION['DtValoreIniziale'] : " . $_SESSION['DtValoreIniziale'];
//                    echo "</br> SESSION['ValoreMacchina'] : " . $_SESSION['ValoreMacchina'];
//                    echo "</br> SESSION['DtModificaMac'] : " . $_SESSION['DtModificaMac'];
//                    echo "</br> SESSION['DtAgg'] : " . $_SESSION['DtAgg'];
//                    echo "</br> SESSION['Filtro']: " . $_SESSION['Filtro'];
//                    echo "</br> SESSION['IdMacchina'] : " . $_SESSION['IdMacchina'];
                    commit();
                    mysql_close();
                    echo $msgInfoTransazioneRiuscita . " ";
                    echo '<a href="modifica_valore_par_comp_stab.php?IdMacchina=' . $_SESSION['IdMacchina'] . '">' . $msgOk . '</a>';
                }
            }//End if errore
            ?>

        </div>
    </body>
</html>

