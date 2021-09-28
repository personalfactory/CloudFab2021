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
            include('../sql/script_valore_par_sacchetto.php');


            $IdCategoria = $_POST['IdCategoria'];
            $NumSacchetti = $_POST['NumSacchetti'];

//#################### GESTIONE ERRORI SULLE QUERY #############################
            $erroreResult = false;
            $sqlValSac = true;
            $insertStoricoValSac = true;
            $updateServerdbValSac = true;

//################# Gestione degli errori sull'input ###########################
//Inizializzo l'errore sui valori dei parametri
            $NumErrore = 0;
            $messaggio = $msgErroreVerificato . '<br/>';

/////////////Eseguo i cicli una prima volta solo per controllare gli errori sui valori

            $sqlValori = selectValoriByIdCatNumSacchi($IdCategoria, $NumSacchetti);
            while ($rowValori = mysql_fetch_array($sqlValori)) {

                //Controllo quantita eventualmente modificata 
                if (!isset($_POST['Valore' . $rowValori['id_val_par_sac']]) || trim($_POST['Valore' . $rowValori['id_val_par_sac']]) == "") {

                    $NumErrore++;
                    $messaggio = $messaggio . " " . $titleValParNumSac . " " . $rowValori['nome_variabile'] . " " . $msgVuoto . "!<br />";
                }
            }//End while finite le categorie

            $messaggio = $messaggio . '<a href="javascript:history.back()">' . $msgRicontrollaDati . '</a>';

            if ($NumErrore > 0) {

                echo $messaggio;
            } else {
                include('../Connessioni/storico.php');

                //##############################################################
                //########## INIZIO TRANSAZIONE ################################
                //##############################################################
                begin();
                if(mysql_num_rows($sqlValori))
                mysql_data_seek($sqlValori, 0);
                while ($rowValori = mysql_fetch_array($sqlValori)) {

                    $ValoreDaInserire = $_POST['Valore' . $rowValori['id_val_par_sac']];

                    $insertStoricoValSac = insertStoricoValoreParSac($rowValori['id_val_par_sac'], $rowValori['id_par_sac'], $IdCategoria, $rowValori['id_num_sac'], $rowValori['sacchetto'], $rowValori['valore_variabile'], $rowValori['abilitato'], $rowValori['dt_abilitato']);

                    $updateServerdbValSac = updateServerdbValSac($rowValori['id_par_sac'], $IdCategoria, $rowValori['id_num_sac'], $rowValori['sacchetto'], $ValoreDaInserire);

                    if (!$updateServerdbValSac OR ! $insertStoricoValSac) {
                        $erroreResult = true;
                    }
                }

                if ($erroreResult) {

                    rollback();

                    echo $msgTransazioneFallita . "! " . $msgErrContattareAdmin;
                    echo "</br>erroreResult : " . $erroreResult;
                
                    
                } else {

                    commit();
                    mysql_close();
                    ?>
                    <script language="javascript">
                        window.location.href = "/CloudFab/prodotti/gestione_categorie.php";
                    </script>
                    <?php
                }
            }//fine  if($NumErrore) controllo input valore
            ?>

        </div>
    </body>
</html>
