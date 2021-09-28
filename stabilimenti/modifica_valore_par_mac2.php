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
           
//Gestione errori sull'input
            $errore = false;
            $messaggio = $msgErroreVerificato.'<br/>';

//######### Variabili utili a gestire gli errori sulle query ###################
            $erroreResult = false;
            $selectParEr = true;
            $selectPar = true;
            $insertStorico = true;
            $updateServerdb = true;

//##############################################################################

            include('../Connessioni/serverdb.php');
            include('../Connessioni/storico.php');
            include('../sql/script_valore_par_sing_mac.php');
            include('../sql/script.php');

//################### INIZIO TRANSAZIONE #######################################            
            begin();

//Seleziono i record vecchi da inserire nello storico dei valori_par_sing_mac prima di salvare la modifica 
//Estraggo la descrizione dei parametri per visualizzarne eventuali errori.
//Utilizzo l'id_par_sm e l'id_macchina per modificare i valori dei parametri.	

            $NParEr = 1;
            $selectParEr = findValoreParSingMacByIdMacchina($_SESSION['IdMacchina'], $_SESSION['Filtro'], $_SESSION['IdValSm'], $_SESSION['IdParSm'], $_SESSION['NomeVariabile'], $_SESSION['ValoreVariabile'], $_SESSION['DtAbilitato'], $_SESSION['ValoreIniziale'], $_SESSION['DtValoreIniziale'], $_SESSION['ValoreMacchina'], $_SESSION['DtModificaMac'], $_SESSION['DtAgg']);
//Memorizzo nelle rispettive variabili i valori (arrivate tramite form) relativi ai valori modificati 
            while ($rowParEr = mysql_fetch_array($selectParEr)) {

                $Valore = $_POST['Valore' . $NParEr];

                //Controllo sui valori eventualmente modificati 
                if (!isset($Valore) || trim($Valore) == "") {

                    $errore = true;
                    $messaggio = $messaggio . " ".$titleValParNumSac." (" . $rowParEr['descri_variabile'] . ") ".$msgVuoto."!<br />";
                }
                $NParEr++;
            }

            $messaggio = $messaggio . '<a href="javascript:history.back()">'.$msgRicontrollaDati.'</a>';

            if ($errore) {
                //Ci sono errori quindi non effettuo la modifica e visualizzo il messaggio di errore
                echo $messaggio;
            } else {// Non ci sono errori quindi posso salvare
                $NPar = 1;
                $selectPar = findValoreParSingMacByIdMacchina($_SESSION['IdMacchina'], $_SESSION['Filtro'], $_SESSION['IdValSm'], $_SESSION['IdParSm'], $_SESSION['NomeVariabile'], $_SESSION['ValoreVariabile'], $_SESSION['DtAbilitato'], $_SESSION['ValoreIniziale'], $_SESSION['DtValoreIniziale'], $_SESSION['ValoreMacchina'], $_SESSION['DtModificaMac'], $_SESSION['DtAgg']);
                //Memorizzo nelle rispettive variabili i valori (arrivate tramite form) relativi ai valori modificati 
                while ($rowPar = mysql_fetch_array($selectPar)) {

                    $Valore = $_POST['Valore' . $NPar];

                    //Inserisco nello storico i vecchi record relativi ai valori parametri che si stanno modificando
                    $insertStorico = insertIntoValoreParSingMacStorico($rowPar['id_val_par_sm'],
                                        $rowPar['id_par_sm'],
                                        $_SESSION['IdMacchina'],
                                        $rowPar['valore_variabile'],
                                        $rowPar['abilitato'],
                                        $rowPar['dt_abilitato']);
                            
                                            
                    //Salvo la modifica nella tabella valore_par_sing_mac di serverdb
                    $updateServerdb = updateValoreParSingMac($Valore, 
                                                              dataCorrenteInserimento(),
                                                              $rowPar['id_par_sm'],
                                                              $_SESSION['IdMacchina']);
                            
                           
                    
                    if (!$insertStorico OR !$updateServerdb) {
                        $erroreResult = true;
                    }

                    $NPar++;
                }// end while finiti i parametri 
                
                if ($erroreResult
                        OR !$updateServerdb
                        OR !$insertStorico
                        OR !$selectPar
                        OR !$selectParEr
                ) {

                    rollback();
                
//                echo "ATTENZIONE TRANSAZIONE NON RIUSCITA! CONTATTARE L' AMMINISTRATORE!";
//                echo "</br>erroreResult : ".$erroreResult;
//                echo "</br>updateServerdb : ".$updateServerdb;
//                echo "</br>insertStorico : ".$insertStorico;
//                echo "</br>selectPar : ".$selectPar;
//                echo "</br>selectParEr : ".$selectParEr;
                    
                } else {

                    commit();
                    mysql_close();
                    ?>
                    <script type="text/javascript">
                        location.href="modifica_valore_par_mac.php?Filtro=<?php echo $_SESSION['Filtro']?>&IdMacchina=<?php echo $_SESSION['IdMacchina']; ?>"
                    </script> 
                <?php
                }
            }//End if errore
            ?>

        </div>
    </body>
</html>
