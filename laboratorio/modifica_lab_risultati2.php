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
        include('../include/precisione.php');
        include('../include/gestione_date.php');
        include('../Connessioni/serverdb.php');
        include('sql/script.php');
        include('sql/script_lab_risultato_car.php');
        
            $IdEsperimento = $_POST['IdEsperimento'];

            //##################################################################
            //################# CONTROLLO INPUT ################################
            //##################################################################
            $NumErroreCar = 0;
            $messaggioCar = "";

            begin();
            $sqlCar = findRisultatoCarByIdEsperimento($IdEsperimento);
            commit();

            $NCar = 1;
            while ($rowCar = mysql_fetch_array($sqlCar)) {

                if (!isset($_POST['Valore' . $NCar])) {
                    $NumErroreCar++;
                    $messaggioCar = $messaggioCar . " " . $rowCar['caratteristica'] . ": " . $msgErrDigitaValore . "<br/>";
                }

                if (($rowCar['tipo_dato']) == $valCarNum) {
                    if (!is_numeric($_POST['Valore' . $NCar])) {
                        $NumErroreCar++;
                        $messaggioCar = $messaggioCar . " " . $rowCar['caratteristica'] . ": " . $msgErrValoreNumerico . "<br/>";
                    }
                }

                $NCar++;
            }// End While finite le caratteristiche

            if ($NumErroreCar > 0) {
                $messaggioCar = $messaggioCar . '<a href="javascript:history.back()">' . $msgRicontrollaDati . '</a>';
                echo $messaggioCar;
            } else {
                //##############################################################			
                //########### INIZIO TRANSAZIONE ###############################
                //##############################################################

                $erroreTransazione = false;
                $updateRisultati = true;

                begin();
                $NCar = 1;
                $messaggioCar = "";
                mysql_data_seek($sqlCar, 0);
                
                while ($rowCarat = mysql_fetch_array($sqlCar)) {
                            
                    $Valore = $_POST['Valore' . $NCar];
                    $ValoreDim = "";
                    if (isSet($_POST['ValoreDim' . $NCar])) {
                        $ValoreDim = $_POST['ValoreDim' . $NCar];
                    }
                    $Note = "";
                    if (isSet($_POST['Note' . $NCar])) {
                        $Note = str_replace("'", "''", $_POST['Note' . $NCar]);
                    }

                    $updateRisultati = modificaRisultatiCar($Valore, $ValoreDim, $IdEsperimento, $rowCarat['id'], $Note);

                    if (!$updateRisultati) {
                        $erroreTransazione = true;
                    }

                    $NCar++;
                }// End While finite le caratteristiche					
                if ($erroreTransazione) {

                    rollback();
                    echo "</br>" . $msgTransazioneFallita;
                } else {

                    commit();
                    echo $msgModificaCompletata . '<a href="modifica_lab_risultati.php?IdEsperimento=' . $IdEsperimento . '">' . $msgOk . '</a>';
                }
            }//End if ($NumErroreCar) controllo degli input relativo ai valori delle caratteristiche
            ?>
        </div>
    </body>
</html>