<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <?php include('../include/validator.php'); ?>
    <head>
        <?php include('../include/header.php'); ?>
    </head>
    <body>
        <?php include('../include/menu.php'); ?>
        <?php include('../include/gestione_date.php'); ?>
        <div id="mainContainer">
            <?php
//            $IdMacchina = $_POST['IdMacchina'];

//Gestione errori sull'input
            $errore = false;
            $messaggio = $msgErroreVerificato.'<br/>';

//######### Variabili utili a gestire gli errori sulle query ###################
            $erroreResult = false;
            $selectParEr = true;
            $$selectParEr = true;
            $insertStorico = true;
            $updateServerdb = true;

//##############################################################################

            include('../Connessioni/serverdb.php');
            include('../Connessioni/storico.php');
            include('../sql/script_valore_ripristino.php');
            include('../sql/script.php');

//################### INIZIO TRANSAZIONE #######################################            
            begin();

//Seleziono i record vecchi da inserire nello storico dei valori_ripristino prima di salvare la modifica 
//Estraggo la descrizione dei parametri per visualizzarne eventuali errori.
//Utilizzo l'id_par_ripristino e l'id_macchina per modificare i valori dei parametri.	

            $NParEr = 1;
            $selectParEr = findValoreRipristinoByIdMacchina( 
                        $_SESSION['IdMacchina'], 
                        $_SESSION['Filtro'],
                        $_SESSION['IdValRip'],
                        $_SESSION['IdParRip'] ,
                        $_SESSION['NomeVariabile'] ,
                        $_SESSION['ValoreVariabile'],
                        $_SESSION['DtAbilitato'],
                        $_SESSION['IdProcesso'],
                        $_SESSION['DtRegistrato'],
                        $_SESSION['DtAggMac'] );
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
                $selectPar = findValoreRipristinoByIdMacchina( 
                        $_SESSION['IdMacchina'], 
                        $_SESSION['Filtro'],
                        $_SESSION['IdValRip'],
                        $_SESSION['IdParRip'] ,
                        $_SESSION['NomeVariabile'] ,
                        $_SESSION['ValoreVariabile'],
                        $_SESSION['DtAbilitato'],
                        $_SESSION['IdProcesso'],
                        $_SESSION['DtRegistrato'],
                        $_SESSION['DtAggMac'] );
                //Memorizzo nelle rispettive variabili i valori (arrivate tramite form) relativi ai valori modificati 
                while ($rowPar = mysql_fetch_array($selectPar)) {

                    $Valore = $_POST['Valore' . $NPar];

                    //Inserisco nello storico i vecchi record relativi ai valori parametri che si stanno modificando
                    $insertStorico = insertIntoStoricoValRipristino(
                                        $rowPar['id_valore_ripristino'],
                                        $rowPar['id_par_ripristino'],
                                        $_SESSION['IdMacchina'],
                                        $rowPar['valore_variabile'],
                                        $rowPar['abilitato'],
                                        $rowPar['dt_abilitato'],
                                        $rowPar['dt_registrato'],    
                                        $rowPar['id_pro_corso']);

                    //Salvo la modifica nella tabella valore_ripristino di serverd
                    $updateServerdb = updateValoreRipristino($Valore,dataCorrenteInserimento(),$rowPar['id_par_ripristino'],$_SESSION['IdMacchina']);
                           
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
                    echo $msgTransazioneFallita. $msgErrContattareAdmin;
                } else {

                    commit();
                    mysql_close();
                    ?>
                    <script type="text/javascript">
                        location.href="modifica_valore_ripristino.php?IdMacchina=<?php echo  $_SESSION['IdMacchina']; ?>"
                    </script> 

                <?php
                }
            }//End if errore
            ?>

        </div>
    </body>
</html>
