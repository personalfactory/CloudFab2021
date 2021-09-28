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

            $IdCategoria = $_POST['IdCategoria'];
            $NumSacchetti = $_POST['NumSacchetti'];
            $arrayTotValori = array();
            
           $countArrayTot = $_POST['countArrayTot'];

            for ($a = 0; $a < $countArrayTot; $a++) {
                
                $arrayTotValori['idValParSac'][$a] = $_POST['arrayTotIdVal' . $a];
                
              
                $arrayTotValori['valoreOld'][$a] = $_POST['arrayTotValoriOld' . $a];
                
            }
            

//#################### GESTIONE ERRORI SULLE QUERY #############################
            $erroreResult = false;
            $insertStoricoValSac = true;
            $updateServerdbValSac = true;

//################# Gestione degli errori sull'input ###########################
//Inizializzo l'errore sui valori dei parametri
            $NumErrore = 0;
            $messaggio = $msgErroreVerificato . '<br/>';

/////////////Eseguo i cicli una prima volta solo per controllare gli errori sui valori
            for ($a = 0; $a < $countArrayTot; $a++) {

                                
                //Controllo quantita eventualmente modificata 
                if (!isset($_POST['Valore' . $arrayTotValori['idValParSac'][$a]]) || $_POST['Valore' . $arrayTotValori['idValParSac'][$a]] == "") {

                    $NumErrore++;
                    $messaggio = $messaggio . " " . $titleValParNumSac . " " . $msgVuoto . "!<br />";
                }
                
            }//End while finite le categorie


            $messaggio = $messaggio . '<a href="javascript:history.back()">' . $msgRicontrollaDati . '</a>';

            if ($NumErrore > 0) {

                echo $messaggio;
                
            } else {
                
                include('../Connessioni/storico.php');
                include('../Connessioni/serverdb.php');
                include('../sql/script.php');
                include('../sql/script_valore_par_sacchetto.php');

                //##############################################################
                //########## INIZIO TRANSAZIONE ################################
                //##############################################################
                begin();


                for ($a = 0; $a < $countArrayTot; $a++) {

                    $IValParSac = $arrayTotValori['idValParSac'][$a];
                    $ValoreOld = $arrayTotValori['valoreOld'][$a];

                    $ValoreDaInserire = $_POST['Valore' . $arrayTotValori['idValParSac'][$a]];

                    if ($ValoreDaInserire != $ValoreOld) {

                        $insertStoricoValSac=storicizzaValoreParSac($IValParSac);

                        $updateServerdbValSac = updateServerdbValSacByIdVal($IValParSac, $ValoreDaInserire);

                        if (!$updateServerdbValSac OR ! $insertStoricoValSac) {
                            $erroreResult = true;
                        }
                    }
                }



                if ($erroreResult) {

                    rollback();

                    echo $msgTransazioneFallita . "! " . $msgErrContattareAdmin;
                    echo "</br>erroreResult : " . $erroreResult;
                } else {

                    commit();
                    mysql_close();
                   
            echo $msgModificaCompletata . ' <a href="/CloudFab/prodotti/gestione_categorie.php">' . $msgOk . '</a><br/>';
                    
               
                }
            }//fine  if($NumErrore) controllo input valore
            ?>

        </div>
    </body>
</html>
